
const routes = [
    {
        path: "/login",
        name: "loginSiswa",
        meta: { public: true },
        component: () => import("@/pages/Siswa/Login.vue"),
    },
    {
        meta: { title: "Tes", menu: 'siswaTes'},
        path: "/tes",
        name: "siswaTes",
        component: () => import('@/pages/Tes/Index.vue'),
    },
    {
        meta: { title: "Layout Siswa" },
        path: "/",
        name: "layout_siswa",
        redirect: '/',
        component: () => import('@/layouts/LayoutSiswa.vue'),
        children: [
            {
                meta: { title: "Dashboard", menu: 'siswaHome'},
                path: "/",
                name: "siswaHome",
                component: () => import('@/pages/Siswa/Home.vue'),
            },
            {
                meta: { title: "Materi", menu: 'siswaMateri'},
                path: "/materi",
                name: "siswaMateri",
                component: () => import('@/pages/Siswa/Materi.vue'),
            },
            {
                meta: { title: "Materi", menu: 'siswaMateri'},
                path: "/materi/:id/params",
                name: "siswaDetailMateri",
                component: () => import('@/pages/Siswa/DetailMateri.vue'),
            },
            {
                meta: { title: "Ujian", menu: 'siswaUjian'},
                path: "/ujian",
                name: "siswaUjian",
                component: () => import('@/pages/Siswa/Ujian.vue'),
            },
            {
                meta: { title: "Ujian", menu: 'siswaUjian'},
                path: "/hasil-ujian",
                name: "siswaHasilUjian",
                component: () => import('@/pages/Siswa/HasilUjian.vue'),
            },
            {
                meta: { title: "profil", menu: 'siswaProfil'},
                path: "/profil",
                name: "siswaProfil",
                component: () => import('@/pages/Siswa/Profil.vue'),
            },
        ]
    },
    {
        path: "/admin/login",
        name: "adminLogin",
        component: () => import("@/pages/Admin/Login.vue"),
        meta: { public: true, admin: true },
    },
    {
        meta: { title: "Layout Admin", admin: true },
        path: "/admin",
        name: "layout_admin",
        redirect: '/admin',
        component: () => import('@/layouts/LayoutAdmin.vue'),
        children: [
            {
                meta: { title: "Home", menu: 'home', admin: true },
                path: "/admin",
                name: "home",
                component: () => import('@/pages/Admin/Home.vue'),
            },
            {
                meta: { title: "Master", menu: 'master', subMenu: 'kelas', admin: true },
                path: "/admin/master",
                name: "master",
                component: () => import('@/pages/Admin/Master/Main.vue'),
                redirect: '/admin/master/kelas',
                children: [
                    {
                        meta: { title: "Kelas", menu: 'master', subMenu: 'kelas', admin: true },
                        path: "/admin/master/kelas",
                        name: "kelas",
                        component: () => import('@/pages/Admin/Master/Kelas.vue'),
                    },
                    {
                        meta: { title: "Mapel", menu: 'master', subMenu: 'mapel', admin: true },
                        path: "/admin/master/mapel",
                        name: "mapel",
                        component: () => import('@/pages/Admin/Master/Mapel.vue'),
                    },
                    {
                        meta: { title: "Rombel", menu: 'master', subMenu: 'rombel', admin: true },
                        path: "/admin/master/rombel",
                        name: "rombel",
                        component: () => import('@/pages/Admin/Master/Rombel.vue'),
                    },
                ]
            },
            {
                meta: { title: "Materi", menu: 'materi', admin: true },
                path: "/admin/materi",
                name: "materi",
                component: () => import('@/pages/Admin/Materi/Main.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi', admin: true },
                path: "/admin/materi/add",
                name: "addMateri",
                component: () => import('@/pages/Admin/Materi/Add.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi', admin: true },
                path: "/admin/materi/:id/show",
                name: "showMateri",
                component: () => import('@/pages/Admin/Materi/Show.vue'),
            },
            {
                meta: { title: "Materi", menu: 'materi', admin: true },
                path: "/admin/materi/:id/edit",
                name: "editMateri",
                component: () => import('@/pages/Admin/Materi/Edit.vue'),
            },
            // end materi

            // soal
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal",
                name: "soal",
                component: () => import('@/pages/Admin/Soal/Main.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal/add",
                name: "addSoal",
                component: () => import('@/pages/Admin/Soal/Add.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal/:id/detail",
                name: "detailSoal",
                component: () => import('@/pages/Admin/Soal/Detail.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal/:id/edit",
                name: "editSoal",
                component: () => import('@/pages/Admin/Soal/Edit.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal/:id/list-pg",
                name: "listPgSoal",
                component: () => import('@/pages/Admin/Soal/ListPg.vue'),
            },
            {
                meta: { title: "Soal", menu: 'soal', admin: true },
                path: "/admin/soal/:id/list-essay",
                name: "listEssaySoal",
                component: () => import('@/pages/Admin/Soal/ListEssay.vue'),
            },
            // end soal
            {
                meta: { title: "Ujian", menu: 'ujian', admin: true },
                path: "/admin/ujian",
                name: "ujian",
                component: () => import('@/pages/Admin/Ujian/Main.vue'),
            },
            {
                meta: { title: "Ujian", menu: 'ujian', admin: true },
                path: "/admin/ujian/add",
                name: "addUjian",
                component: () => import('@/pages/Admin/Ujian/Add.vue'),
            },

            // user
            {
                meta: { title: "Users", menu: 'users', admin: true },
                path: "/admin/users",
                name: "users",
                component: () => import('@/pages/Admin/User/Main.vue'),
                redirect: '/admin/users/guru',
                children: [
                    {
                        meta: { title: "Guru", menu: 'users', subMenu: 'guru', admin: true },
                        path: "/admin/users/guru",
                        name: "guru",
                        component: () => import('@/pages/Admin/User/Guru.vue'),
                    },
                    {
                        meta: { title: "Guru", menu: 'users', subMenu: 'guru', admin: true },
                        path: "/admin/users/guru/add",
                        name: "addGuru",
                        component: () => import('@/pages/Admin/User/AddGuru.vue'),
                    },
                    {
                        meta: { title: "Siswa", menu: 'users', subMenu: 'siswa', admin: true },
                        path: "/admin/users/siswa",
                        name: "siswa",
                        component: () => import('@/pages/Admin/User/Siswa.vue'),
                    },
                ]
            },
            // end user
        ]
    }
  ];

export default routes