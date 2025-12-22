<?php

namespace App\Http\Controllers;

use App\Models\AuqafOfficial;
use App\Models\Maddarsa;
use App\Models\Mousque;
use App\Models\MousqueImage;
use App\Models\Sector;
use App\Models\Shop;
use App\Models\UtilityConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MousqueController extends Controller
{
    public function index(Request $request)
    {
        $query = Mousque::with([
            'sector',
            'officials',
            'shops',
            'maddarsa'
        ]);

        // Mosque name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        // Filter by Official (name / CNIC / mobile)
        if ($request->filled('official')) {
            $search = $request->official;

            $query->whereHas('officials', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('cnic', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        // Sector
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }

        // Sub sector
        if ($request->filled('sub_sector')) {
            $query->where('sub_sector', 'like', '%' . $request->sub_sector . '%');
        }

        // Has shops
        if ($request->filled('has_shops')) {
            if ($request->has_shops == '1') {
                $query->whereHas('shops');
            } else {
                $query->whereDoesntHave('shops');
            }
        }

        // Has madrassa
        if ($request->filled('has_maddarsa')) {
            if ($request->has_maddarsa == '1') {
                $query->whereHas('maddarsa');
            } else {
                $query->whereDoesntHave('maddarsa');
            }
        }

        $mousques = $query
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $sectors = Sector::orderBy('name')->get();

        return view('auqaf.mousques.index', compact('mousques', 'sectors'));
    }


    public function create()
    {
        $sectors = Sector::all();
        $positions = [
            1 => 'Khateeb',
            2 => 'Moazzin',
            3 => 'Khadim',
        ];
        return view('auqaf.mousques.create', compact('sectors', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // ================= MOSQUE =================
            'name'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'sector_id'   => 'required|exists:sectors,id',
            'sub_sector'  => 'nullable|string|max:10',
            'location'    => 'required|string|max:255',
            'sect'        => 'required|in:Barelvi,Deobandi,Ahl-e-Hadith,Shia,Other',
            'status'      => 'required|in:0,1',

            // ================= MOSQUE IMAGES =================
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            // ================= SHOPS =================
            'shops'                       => 'nullable|array',
            'shops.*.occupier_name'       => 'required_with:shops|string|max:255',
            'shops.*.shop_description'    => 'required_with:shops|string|max:255',
            'shops.*.rent_amount'         => 'required_with:shops|integer|min:0',
            'shops.*.image'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // ================= MADARSA =================
            'maddarsa_name'   => 'nullable|string|max:255',
            'no_of_students'  => 'nullable|integer|min:0',
            'official_id'     => 'nullable|integer',

            // ================= UTILITIES =================
            'utilities'                           => 'nullable|array',
            'utilities.*.utility_type'            => 'required_with:utilities|in:Electricity,Water,Gas',
            'utilities.*.reference_number'        => 'required_with:utilities|string|distinct',
            'utilities.*.benificiary_type'        => 'required_with:utilities|in:Khateeb,Moazin,Khadim',
        ]);

        DB::transaction(function () use ($request, $validated) {

            // 1️⃣ Create Mosque
            $mousque = Mousque::create([
                'name'        => $validated['name'],
                'address'     => $validated['address'],
                'sector_id'   => $validated['sector_id'],
                'sub_sector'  => $validated['sub_sector'] ?? null,
                'location'    => $validated['location'],
                'sect'        => $validated['sect'],
                'status'      => $validated['status'],
            ]);

            // 2️⃣ Mosque Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('mousques', 'public');

                    MousqueImage::create([
                        'mousque_id' => $mousque->id,
                        'image_path' => $path,
                    ]);
                }
            }
            // ================= OFFICIALS (CREATE ONLY) =================
            if ($request->has('officials')) {
                foreach ($request->officials as $index => $data) {

                    // Skip empty rows
                    if (
                        empty($data['name']) &&
                        empty($data['father_name']) &&
                        empty($data['cnic'])
                    ) {
                        continue;
                    }

                    $imagePath = null;

                    if ($request->hasFile("officials.$index.profile_image")) {
                        $imagePath = $request
                            ->file("officials.$index.profile_image")
                            ->store('officials', 'public');
                    }

                    AuqafOfficial::create([
                        'mousque_id'     => $mousque->id,
                        'name'           => $data['name'],
                        'father_name'    => $data['father_name'],
                        'position'       => $data['position'],
                        'contact_number' => $data['contact_number'],
                        'cnic'           => $data['cnic'],
                        'type'           => $data['type'],
                        'profile_image'  => $imagePath,
                    ]);
                }
            }
            // 3️⃣ Shops (with image saved in shops table)
            if (!empty($validated['shops'])) {
                foreach ($validated['shops'] as $index => $shopData) {

                    $shopImagePath = null;

                    if ($request->hasFile("shops.$index.image")) {
                        $shopImagePath = $request
                            ->file("shops.$index.image")
                            ->store('shops', 'public');
                    }

                    Shop::create([
                        'mousque_id'       => $mousque->id,
                        'occupier_name'    => $shopData['occupier_name'],
                        'shop_description' => $shopData['shop_description'],
                        'rent_amount'      => $shopData['rent_amount'],
                        'shop_image'       => $shopImagePath,
                    ]);
                }
            }

            // 4️⃣ Maddarsa
            if (!empty($validated['maddarsa_name'])) {
                Maddarsa::create([
                    'mousque_id'     => $mousque->id,
                    'name'           => $validated['maddarsa_name'],
                    'no_of_students' => $validated['no_of_students'] ?? 0,
                    'mohtamim_name'    => $validated['mohtamim_name'] ?? '',],
                );
            }

            // 5️⃣ Utilities
            if (!empty($validated['utilities'])) {
                foreach ($validated['utilities'] as $utility) {
                    UtilityConnection::create([
                        'mousque_id'       => $mousque->id,
                        'utility_type'     => $utility['utility_type'],
                        'reference_number' => $utility['reference_number'],
                        'benificiary_type' => $utility['benificiary_type'],
                    ]);
                }
            }
        });

        return redirect()
            ->route('mousques.index')
            ->with('success', 'Mosque record created successfully.');
    }

    public function edit($id)
    {
        $mousque = Mousque::findOrFail($id);
        $sectors = Sector::all();
        $positions = [
            1 => 'Khateeb',
            2 => 'Moazzin',
            3 => 'Khadim',
        ];
        return view('auqaf.mousques.edit', compact('mousque', 'sectors', 'positions'));
    }
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $mousque = Mousque::findOrFail($id);

            // 1️⃣ Update main mosque
            $mousque->update($request->only([
                'name','address','sector_id','sub_sector',
                'location','sect','status'
            ]));

            // Update maddarsa details
            if (
                !empty($request->maddarsa_name) ||
                !empty($request->no_of_students) ||
                !empty($request->mohtamim_name)
            ) {
                Maddarsa::updateOrCreate(
                    ['id' => $request->maddarsa_id],
                    [
                        'mousque_id'     => $mousque->id,
                        'name'           => $request->maddarsa_name,
                        'no_of_students' => $request->no_of_students ?? 0,
                        'mohtamim_name'  => $request->mohtamim_name ?? '',
                    ]
                );
            }

            // ================= OFFICIALS (UPDATE) =================
            foreach ($request->officials ?? [] as $index => $data) {

                // ❌ Delete existing official
                if (!empty($data['_delete']) && !empty($data['id'])) {
                    AuqafOfficial::where('id', $data['id'])->delete();
                    continue;
                }

                // 🔄 Update existing official
                if (!empty($data['id'])) {

                    $official = AuqafOfficial::findOrFail($data['id']);

                    $official->update([
                        'name'           => $data['name'],
                        'father_name'    => $data['father_name'],
                        'position'       => $data['position'],
                        'contact_number' => $data['contact_number'],
                        'cnic'           => $data['cnic'],
                        'type'           => $data['type'],
                    ]);

                    if ($request->hasFile("officials.$index.profile_image")) {
                        $official->profile_image = $request
                            ->file("officials.$index.profile_image")
                            ->store('officials', 'public');
                        $official->save();
                    }

                    continue;
                }

                // ➕ Create new official
                $imagePath = null;

                if ($request->hasFile("officials.$index.profile_image")) {
                    $imagePath = $request
                        ->file("officials.$index.profile_image")
                        ->store('officials', 'public');
                }

                AuqafOfficial::create([
                    'mousque_id'     => $mousque->id,
                    'name'           => $data['name'],
                    'father_name'    => $data['father_name'],
                    'position'       => $data['position'],
                    'contact_number' => $data['contact_number'],
                    'cnic'           => $data['cnic'],
                    'type'           => $data['type'],
                    'profile_image'  => $imagePath,
                ]);
            }
            // ================= SHOPS =================
            foreach ($request->shops ?? [] as $shopData) {

                // ❌ Delete
                if (!empty($shopData['_delete']) && !empty($shopData['id'])) {
                    Shop::where('id', $shopData['id'])->delete();
                    continue;
                }

                // 🔄 Update existing
                if (!empty($shopData['id'])) {
                    $shop = Shop::find($shopData['id']);

                    $shop->update([
                        'occupier_name'    => $shopData['occupier_name'],
                        'shop_description' => $shopData['shop_description'],
                        'rent_amount'      => $shopData['rent_amount'],
                    ]);

                    if ($request->hasFile("shops.{$shopData['id']}.image")) {
                        $shop->shop_image = $request
                            ->file("shops.{$shopData['id']}.image")
                            ->store('shops', 'public');
                        $shop->save();
                    }
                }

                // ➕ Create new
                if (empty($shopData['id'])) {
                    $path = null;
                    if (!empty($shopData['image'])) {
                        $path = $shopData['image']->store('shops', 'public');
                    }

                    Shop::create([
                        'mousque_id'       => $mousque->id,
                        'occupier_name'    => $shopData['occupier_name'],
                        'shop_description' => $shopData['shop_description'],
                        'rent_amount'      => $shopData['rent_amount'],
                        'shop_image'       => $path,
                    ]);
                }
            }

            // ================= UTILITIES =================
            foreach ($request->utilities ?? [] as $utility) {

                if (!empty($utility['_delete']) && !empty($utility['id'])) {
                    UtilityConnection::where('id', $utility['id'])->delete();
                    continue;
                }

                if (!empty($utility['id'])) {
                    UtilityConnection::where('id', $utility['id'])->update([
                        'utility_type'     => $utility['utility_type'],
                        'reference_number' => $utility['reference_number'],
                        'benificiary_type' => $utility['benificiary_type'],
                    ]);
                }

                if (empty($utility['id'])) {
                    UtilityConnection::create([
                        'mousque_id'       => $mousque->id,
                        'utility_type'     => $utility['utility_type'],
                        'reference_number' => $utility['reference_number'],
                        'benificiary_type' => $utility['benificiary_type'],
                    ]);
                }
            }
        });

        return redirect()->route('mousques.index')
            ->with('success', 'Mosque updated successfully.');
    }
    public function show($id)
    {
        $mousque = Mousque::with([
            'sector',
            'images',
            'officials',
            'shops',
            'maddarsa'
        ])->findOrFail($id);

        return view('auqaf.mousques.show', compact('mousque'));
    }


}
