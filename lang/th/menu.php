<?php

  
$menuItems = [
    [
        'menu-name' => 'usermanage-menu',
        'label' => 'จัดการ User',
        'url' => 'usermanage',
        'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
        'subMenuItems' => [],
    ],
    [
        'menu-name' => 'branchmanage-menu',
        'label' => 'จัดการสาขา',
        'url' => 'branchmanage',
        'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
        'subMenuItems' => [],
    ],
    [
        'menu-name' => 'carmanage-menu',
        'label' => 'จัดการเลขรถ',
        'url' => 'carsmanage',
        'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
        'subMenuItems' => [],
    ],
    [
        'menu-name' => 'customermanage-menu',
        'label' => 'จัดการลูกค้า',
        'url' => 'cusmanage',
        'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'subMenuItems' => [],
    ],
    [
        'menu-name' => 'billsystem-menu',
        'label' => 'ออกบิลอื่นๆ',
        'url' => 'otherbill',
        'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z',
        'subMenuItems' => [],
    ],
    [
        'menu-name' => 'report-menu',
        'label' => 'รายงาน',
        'url' => '',
        'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z',
        'subMenuItems' => [
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานลูกค้าทั้งหมด',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานรายรับรายวัน',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานรายรับแยกต้น - ดอกเบี้ย',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานติดตามลูกค้า',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานสรุปลูกค้า',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานติดตามลูกค้ารถยึด',
                'url' => 'usermanage',
            ],
            [
                'menu-name' => 'report-sub',
                'label' => 'รายงานส่วนลด',
                'url' => 'getdiscountbill',
            ],
        ],
    ],
    [
        'menu-name' => 'setting-menu',
        'label' => 'ตั้งค่า',
        'url' => '',
        'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z',
        'subMenuItems' => [
            [
                'menu-name' => 'setting-sub',
                'label' => 'จัดการ User Level',
                'url' => 'userlevelmanage',
            ],
            [
                'menu-name' => 'setting-sub',
                'label' => 'จัดการสถานะลูกค้า',
                'url' => 'customerstatus',
            ],
            [
                'menu-name' => 'setting-sub',
                'label' => 'จัดการสถานะรถ',
                'url' => 'carstatus',
            ],
            [
                'menu-name' => 'setting-sub',
                'label' => 'จัดการสถานะการจ่ายบิล',
                'url' => 'billstatus',
            ],
            [
                'menu-name' => 'setting-sub',
                'label' => 'จัดการสถานะเอกสาร',
                'url' => 'docstatus',
            ],
        ],
    ],
    
];

return $menuItems;

?>