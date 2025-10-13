@props(['name', 'class' => 'w-5 h-5'])

@php
    $icons = [
        // 🌐 Navigation / Interface
        'home' => '<path d="M3 9.75L12 3l9 6.75V21a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>',
        'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83"/>',
        'bell' => '<path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>',
        'user' => '<path d="M5.121 17.804A9 9 0 1118.879 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'users' => '<path d="M17 21v-2a4 4 0 00-3-3.87"/><path d="M7 21v-2a4 4 0 013-3.87"/><circle cx="12" cy="7" r="4"/>',
        'lock' => '<rect x="4" y="11" width="16" height="11" rx="2"/><path d="M12 16v2"/><path d="M8 11V7a4 4 0 118 0v4"/>',
        'unlock' => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 019.9-1"/>',
        'key' => '<circle cx="7.5" cy="15.5" r="5.5"/><path d="M12 10l10-10v4h-4v4h-4z"/>',

        // 📄 Files & Actions
        'file' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/>',
        'file-text' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8M16 17H8M10 9H8"/>',
        'upload' => '<path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/><path d="M7 9l5-5 5 5"/><path d="M12 4v12"/>',
        'download' => '<path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
        'save' => '<path d="M5 5v14a2 2 0 002 2h10a2 2 0 002-2V7l-4-4H7a2 2 0 00-2 2z"/>',
        'clipboard' => '<rect x="9" y="2" width="6" height="4" rx="1"/><path d="M4 7h16v13a2 2 0 01-2 2H6a2 2 0 01-2-2z"/>',
        'folder' => '<path d="M3 7h5l2 3h11a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2z"/>',
        'archive' => '<rect x="3" y="4" width="18" height="4" rx="1"/><path d="M3 8v12a2 2 0 002 2h14a2 2 0 002-2V8"/><line x1="10" y1="12" x2="14" y2="12"/>',

        // ✏️ CRUD & UI Actions
        'eye' => '<path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'edit' => '<path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4z"/>',
        'trash' => '<path d="M3 6h18M9 6v12a2 2 0 002 2h2a2 2 0 002-2V6M10 10h4"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'minus' => '<path d="M5 12h14"/>',
        'x' => '<path d="M18 6L6 18M6 6l12 12"/>',
        'check' => '<path d="M20 6L9 17l-5-5"/>',
        'refresh' => '<path d="M4.93 4.93A10.5 10.5 0 1120 12h-1.5a9 9 0 10-9-9V2z"/>',
        'filter' => '<path d="M4 4h16l-6 8v6l-4 2v-8z"/>',
        'sort' => '<path d="M10 11H3l7-8v8zm4 2h7l-7 8v-8z"/>',
        'more-vertical' => '<circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>',

        // 🧾 Documents / Office
        'book' => '<path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M4 4h16v13H4z"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
        'id-card' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M15 8h3M15 12h3M9 14h6"/>',

        // 💬 Communication
        'mail' => '<path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.11 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012.05 0h3a2 2 0 012 1.72 12.44 12.44 0 002.05 5.52l-1.34 1.34a16 16 0 007.11 7.11l1.34-1.34a12.44 12.44 0 005.52 2.05A2 2 0 0122 16.92z"/>',
        'message' => '<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5"/>',

        // ⚙️ System / Indicators
        'alert-triangle' => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'info' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        'check-circle' => '<path d="M22 11.08V12a10 10 0 11-10-10"/><path d="M22 4L12 14.01l-3-3"/>',
        'x-circle' => '<circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>',
        'loading' => '<path d="M21 12a9 9 0 11-9-9v3"/>',
        'star' => '<polygon points="12 2 15 10 23 10 17 14 19 22 12 17 5 22 7 14 1 10 9 10 12 2"/>',

        // 💰 Finance / Commerce
        'dollar-sign' => '<path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>',
        'shopping-cart' => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l3.6 7.59L5.25 14H19a1 1 0 001-1v-6H6"/>',
        'credit-card' => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
        'wallet' => '<path d="M4 5h16a2 2 0 012 2v2H4z"/><path d="M4 9h18v8a2 2 0 01-2 2H4z"/>',
    ];
@endphp

<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke-width="2"
     stroke="currentColor"
     {{ $attributes->merge(['class' => $class]) }}>
    {!! $icons[$name] ?? '' !!}
</svg>
