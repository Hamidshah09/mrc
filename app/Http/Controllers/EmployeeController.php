<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Models\department;
use App\Models\designation;
use App\Models\employee;
use App\Models\employee_type;
use App\Models\employeeCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request){
        if (!empty($request->search)) { 
            $query = employee::with('departments', 'designations', 'employee_types')
                        ->orderByDesc('id');
            if($request->search_type=='cnic'){
                $query->where('cnic','like', "%".$request->search."%"); 
            }elseif($request->search_type=='name'){
                $query->where('name','like', "%".$request->search."%");
            }elseif($request->search_type=='id'){
                $query->where('id', $request->search);
            }
            $employees = $query->paginate(10);
                        
        }else{
            $employees = employee::with('departments', 'designations', 'employee_types')
                        ->orderByDesc('id')
                        ->paginate(10);
        }
        

        // return $employees;
        return view('Employee.index', compact('employees'));
    }
    public function show($id)
    {
        // Fetch the employee record from the database
        $employee = employee::where('cnic', $id)->select('cnic', 'name', 'father_name')->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Return the employee data as JSONp
        return response()->json($employee);
    }

    public function create(){
        $designations = designation::all();
        $departments = department::all();
        $employee_type = employee_type::all();
        return view('Employee.create', compact('designations', 'departments', 'employee_type'));
    }
    public function store(Request $request){
        $user = Auth::user();
        $validated_data = $request->validate([
            'cnic' => 'required|string|max:255|unique:employees,CNIC', // Ensure CNIC is unique
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'department_id' => 'required|integer|exists:departments,id', // Ensure it matches an existing department
            'designation_id' => 'required|integer|exists:designations,id', // Ensure it matches an existing designation
            'date_of_birth' => 'nullable|date', // Ensure valid date format
            'date_of_joining' => 'nullable|date', // Ensure valid date format
            'emp_type_id' => 'nullable|integer|exists:employee_types,id', // Ensure it matches an existing employee type
            
        ]);
        $validated_data['user_id'] = $user->id;
        $employee = employee::create($validated_data);
        
        if ($request->hasFile('pic')) {
            $request->validate([ 
                'pic' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ],[
                'pic.required'=>'Scaned documents are required',
            ]);
            $path = $request->file('pic')->store('db_images', 'public');
            employee::where('id', $employee->id)->update(['pic'=>$path]);
        } 
        
        return redirect()->route('Employee.index');
    }
    public function edit($id){
        $employee = employee::with('departments', 'designations', 'employee_types')
                                ->findorfail($id);
        $designations = designation::all();
        $departments = department::all();
        $employee_cards = employeeCard::with(['users'=>function($q){$q->select('id', 'name');}])->where('employee_id', $id)->get();
        
        return view('Employee.edit', compact('employee', 'designations', 'departments', 'employee_cards'));
    }
    public function update(Request $request, $id){
        $user = Auth::user();
        $validated_data = $request->validate([
            'cnic' => 'required|string|max:255', // Ensure CNIC is unique
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'department_id' => 'required|integer|exists:departments,id', // Ensure it matches an existing department
            'designation_id' => 'required|integer|exists:designations,id', // Ensure it matches an existing designation
            'date_of_birth' => 'nullable|date', // Ensure valid date format
            'date_of_joining' => 'nullable|date', // Ensure valid date format
            'emp_type_id' => 'nullable|integer|exists:employee_types,id', // Ensure it matches an existing employee type
            
        ]);
        employee::findorfail($id)->update($validated_data);
        $employee = employee::findorfail($id);
        if ($request->hasFile('pic')) {
            $request->validate([ 
                'pic' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ],[
                'pic.required' => 'Picture is required',
            ]);
        
            // Get the existing image path
            $oldImagePath = $employee->pic;
        
            // Store the new image
            $newImagePath = $request->file('pic')->store('db_images', 'public');
        
            // Update the employee record with the new image path
            employee::where('id', $employee->id)->update(['pic' => $newImagePath]);
        
            // Delete the old image if it exists
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }
         
        
        return redirect()->route('Employee.index');
    }
    public function issueCard($id)
    {
        try {
            // Validate that an ID is provided
            if ($id == 0) {
                return redirect()->route('Employee.index')->with('error', 'Please select a record from the grid');
            }

            // Fetch employee data
            $employee = Employee::where('id', $id)
                ->with('designations', 'departments', 'employee_types')
                ->first();

            if (!$employee) {
                return redirect()->route('Employee.index')->with('error', 'No record found');
            }

            $emp_id     = $employee->id;
            $cnic       = $employee->cnic;
            $name       = $employee->name;
            $designation = $employee->designations->designation ?? '';
            $department  = $employee->departments->department ?? '';
            $emp_status  = $employee->employee_types->employee_type ?? '';
            $pic        = $employee->pic;
            $dob        = Carbon::parse($employee->date_of_birth)->format('d-m-Y');

            // Handle permanent vs non-permanent
            if ($emp_status === 'Permanent') {
                $existingCard = DB::table('employee_cards')->where('employee_id', $emp_id)->first();

                if ($existingCard) {
                    // Generate image for the existing card
                    $result = $this->generateImage(
                        $existingCard->card_no,
                        $pic,
                        $existingCard->employee_id,
                        $cnic,
                        $name,
                        $designation,
                        $department,
                        $dob,
                        $existingCard->issue_date,
                        'Till Service',         
                    );
                    if ($result){
                        return redirect()->route('Employee.index')->with('status', 'Card successfully generated!');    
                    }else{
                        return redirect()->route('Employee.index')->with('error', $result);
                    }
                } else {
                    // Generate new card
                    $result = $this->createNewCard($emp_id, $pic, $cnic, $name, $designation, $department, $dob, false);
                    if ($result){
                        return redirect()->route('Employee.index')->with('status', 'Card successfully generated!');    
                    }else{
                        return redirect()->route('Employee.index')->with('error', $result);
                    }
                }
            } else {
                // Non-permanent
                $result = $this->createNewCard($emp_id, $pic, $cnic, $name, $designation, $department, $dob, false);
                if ($result){
                    return redirect()->route('Employee.index')->with('status', 'Card successfully generated!');    
                }else{
                    return redirect()->route('Employee.index')->with('error', $result);
                }
            }

            
        } catch (\Exception $e) {
            return redirect()->route('Employee.index')->with('error', $e->getMessage());
        }
    }

/**
 * Helper to create a new card
 */
private function createNewCard($emp_id, $pic, $cnic, $name, $designation, $department, $dob, $isPermanent)
{
    
    // Generate card details
    $lastCardId = DB::table('employee_cards')->max('id') ?? 0;
    $nextId     = $lastCardId + 1;
    $card_no = date('Ymd') . $nextId;

    // Format dates
    $dateofissue = date('Y-m-d');
    $dateofexpiry = $isPermanent ? 'Till Service' : date('Y-m-d', strtotime('+1 year'));

    // Insert new card record
    DB::table('employee_cards')->insert([
        'employee_id' => $emp_id,
        'card_no' => $card_no,
        'issue_date' => $dateofissue,
        'expiry_date' => $dateofexpiry,
        'user_id'=>Auth::id(),
        'created_at'=> date('Y-m-d'),
    ]);

    // Generate image for the card
    return $this->generateImage($card_no, $pic, $emp_id, $cnic, $name, $designation, $department, $dob, $dateofissue, $dateofexpiry);
}
// $card_no, $pic, $emp_id, $cnic, $name, $designation, $department, $dob, c
    public function generateImage($card_no, $pic, $emp_id, $cnic, $name, $designation, $department, $dob, $dateofissue, $dateofexpiry)
    {
        try {
            // Load the template image
             $templatePath = public_path('images/temp.png');
            if (!file_exists($templatePath)) {
                return back()->with('error', 'Template Image Not Found');
            }

            $template = Image::make($templatePath);

            // Load employee picture (works with JPG/PNG automatically)
            $picPath = public_path('storage/' . $pic);
            if (!file_exists($picPath)) {
                return back()->with('error', 'Employee Image Not Found: ' . $picPath);
            }

            // Resize employee picture to fit ID card slot
            $empPic = Image::make($picPath)->resize(215, 215);

            // Insert employee picture onto template (x=69, y=209)
            $template->insert($empPic, 'top-left', 69, 209);

            // Define font path
            $fontPath = public_path('fonts/CALISTB.TTF');
            if (!file_exists($fontPath)) {
                return back()->with('error', 'Font file Not Found');
            }

            // Helper function to add text
            $addText = function ($text, $x, $y) use ($template, $fontPath) {
                $template->text($text, $x, $y, function ($font) use ($fontPath) {
                    $font->file($fontPath);
                    $font->size(32);
                    $font->color('#000000'); // Black
                    $font->align('left');
                    $font->valign('top');
                });
            };

            // Add employee details
            $addText($card_no,    542, 218);
            $addText($name,       542, 258);
            $addText($designation,542, 300);
            $addText($department, 542, 340);
            $addText($cnic,       542, 382);
            $addText($dob,        542, 425);
            $addText($dateofissue,542, 468);
            $addText($dateofexpiry,542, 509);

            // Save the generated card
            $outputPath = public_path('cards/' . $name . '_' . $emp_id . '.png');
            $template->save($outputPath, 100, 'png'); // quality=100

            // Free memory

            return true;
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }


    
}
