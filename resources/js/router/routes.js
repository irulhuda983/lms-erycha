
const routes = [
    {
        path: "/admin/login",
        name: "adminLogin",
        component: () => import("@/pages/Admin/Login.vue"),
        meta: { public: true },
    },
    {
        meta: { title: "Layout Admin" },
        path: "/admin",
        name: "layout_admin",
        redirect: '/admin',
        component: () => import('@/layouts/LayoutAdmin.vue'),
        children: [
            {
                meta: { title: "Home", menu: 'home' },
                path: "/admin",
                name: "home",
                component: () => import('@/pages/Admin/Home.vue'),
            },
            {
                meta: { title: "Master", menu: 'master', subMenu: 'kelas' },
                path: "/admin/master",
                name: "master",
                component: () => import('@/pages/Admin/Master/Main.vue'),
                redirect: '/admin/master/kelas',
                children: [
                    {
                        meta: { title: "Kelas", menu: 'master', subMenu: 'kelas' },
                        path: "/admin/master/kelas",
                        name: "kelas",
                        component: () => import('@/pages/Admin/Master/Kelas.vue'),
                    },
                    {
                        meta: { title: "Mapel", menu: 'master', subMenu: 'mapel' },
                        path: "/admin/master/mapel",
                        name: "mapel",
                        component: () => import('@/pages/Admin/Master/Mapel.vue'),
                    },
                    {
                        meta: { title: "Rombel", menu: 'master', subMenu: 'rombel' },
                        path: "/admin/master/rombel",
                        name: "rombel",
                        component: () => import('@/pages/Admin/Master/Rombel.vue'),
                    },
                ]
            },
            {
                meta: { title: "Materi", menu: 'materi' },
                path: "/admin/materi",
                name: "materi",
                component: () => import('@/pages/Admin/Materi/Main.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi' },
                path: "/admin/materi/add",
                name: "addMateri",
                component: () => import('@/pages/Admin/Materi/Add.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi' },
                path: "/admin/materi/:id/show",
                name: "showMateri",
                component: () => import('@/pages/Admin/Materi/Show.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi' },
                path: "/admin/materi/:id/edit",
                name: "editMateri",
                component: () => import('@/pages/Admin/Materi/Edit.vue'),
            },
            // end materi

            // soal
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal",
                name: "soal",
                component: () => import('@/pages/Admin/Soal/Main.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal/add",
                name: "addSoal",
                component: () => import('@/pages/Admin/Soal/Add.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal/:id/detail",
                name: "detailSoal",
                component: () => import('@/pages/Admin/Soal/Detail.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal/:id/edit",
                name: "editSoal",
                component: () => import('@/pages/Admin/Soal/Edit.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal/:id/list-pg",
                name: "listPgSoal",
                component: () => import('@/pages/Admin/Soal/ListPg.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal' },
                path: "/admin/soal/:id/list-essay",
                name: "listEssaySoal",
                component: () => import('@/pages/Admin/Soal/ListEssay.vue'),
            },
            // end soal
            {
                meta: { title: "Ujian", menu: 'ujian' },
                path: "/admin/ujian",
                name: "ujian",
                component: () => import('@/pages/Admin/Ujian.vue'),
            },

            // user
            {
                meta: { title: "Users", menu: 'users' },
                path: "/admin/users",
                name: "users",
                component: () => import('@/pages/Admin/User/Main.vue'),
                redirect: '/admin/users/guru',
                children: [
                    {
                        meta: { title: "Guru", menu: 'users', subMenu: 'guru' },
                        path: "/admin/users/guru",
                        name: "guru",
                        component: () => import('@/pages/Admin/User/Guru.vue'),
                    },
                    {
                        meta: { title: "Guru", menu: 'users', subMenu: 'guru' },
                        path: "/admin/users/guru/add",
                        name: "addGuru",
                        component: () => import('@/pages/Admin/User/AddGuru.vue'),
                    },
                    {
                        meta: { title: "Siswa", menu: 'users', subMenu: 'siswa' },
                        path: "/admin/users/siswa",
                        name: "siswa",
                        component: () => import('@/pages/Admin/User/Siswa.vue'),
                    },
                ]
            },
            // end user
        ]
    },
  ];

export default routes