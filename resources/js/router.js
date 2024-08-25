import { createWebHistory, createRouter } from "vue-router";
import middlewares from "./middlewares";
import { useAuthStore } from "./stores/authStore";

const routes = [
    {
        path: "/login",
        name: "login",
        meta: {
            middlewares: [middlewares.guest],
        },
        component: () => import("./views/Login.vue"),
    },
    {
        path: "/403",
        name: "access denied",
        meta: {
            middlewares: [middlewares.auth],
        },
        component: () => import("./views/AccessDenied.vue"),
    },
    {
        meta: {
            middlewares: [middlewares.auth, middlewares.canAccessAdminPanel],
        },
        children: [
            {
                path: "/",
                name: "home",
                component: () => import("./views/Home.vue"),
            },
            {
                path: "/products",
                name: "all products",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Product/Index.vue"),
            },
            {
                path: "/product",
                children: [
                    {
                        path: "create",
                        name: "add product",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Product/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show product",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Product/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit product",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Product/Edit.vue"),
                    },
                ],
            },
            {
                path: "/categories",
                name: "all categories",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Category/Index.vue"),
            },
            {
                path: "/category",
                children: [
                    {
                        path: "create",
                        name: "add category",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Category/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show category",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Category/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit category",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Category/Edit.vue"),
                    },
                ],
            },
            {
                path: "/subcategories",
                name: "all subcategories",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Subcategory/Index.vue"),
            },
            {
                path: "/subcategory",
                children: [
                    {
                        path: "create",
                        name: "add subcategory",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () =>
                            import("./views/Subcategory/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show subcategory",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Subcategory/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit subcategory",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Subcategory/Edit.vue"),
                    },
                ],
            },
            {
                path: "/types",
                name: "all types",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Type/Index.vue"),
            },
            {
                path: "/type",
                children: [
                    {
                        path: "create",
                        name: "add type",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Type/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show type",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Type/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit type",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Type/Edit.vue"),
                    },
                ],
            },
            {
                path: "/manufacturers",
                name: "all manufacturers",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Manufacturer/Index.vue"),
            },
            {
                path: "/manufacturer",
                children: [
                    {
                        path: "create",
                        name: "add manufacturer",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () =>
                            import("./views/Manufacturer/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show manufacturer",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () =>
                            import("./views/Manufacturer/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit manufacturer",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () =>
                            import("./views/Manufacturer/Edit.vue"),
                    },
                ],
            },
            {
                path: "/sizes",
                name: "all sizes",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Size/Index.vue"),
            },
            {
                path: "/size",
                children: [
                    {
                        path: "create",
                        name: "add size",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Size/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show size",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Size/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit size",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Size/Edit.vue"),
                    },
                ],
            },
            {
                path: "/colors",
                name: "all colors",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Color/Index.vue"),
            },
            {
                path: "/color",
                children: [
                    {
                        path: "create",
                        name: "add color",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Color/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show color",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Color/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit color",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Color/Edit.vue"),
                    },
                ],
            },
            {
                path: "/materials",
                name: "all materials",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Material/Index.vue"),
            },
            {
                path: "/material",
                children: [
                    {
                        path: "create",
                        name: "add material",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Material/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show material",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Material/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit material",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Material/Edit.vue"),
                    },
                ],
            },
            {
                path: "/seasons",
                name: "all seasons",
                meta: {
                    permissions: ["show products and product features"],
                },
                component: () => import("./views/Season/Index.vue"),
            },
            {
                path: "/season",
                children: [
                    {
                        path: "create",
                        name: "add season",
                        meta: {
                            permissions: [
                                "create products and product features",
                            ],
                        },
                        component: () => import("./views/Season/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show season",
                        meta: {
                            permissions: ["show products and product features"],
                        },
                        component: () => import("./views/Season/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit season",
                        meta: {
                            permissions: [
                                "update products and product features",
                            ],
                        },
                        component: () => import("./views/Season/Edit.vue"),
                    },
                ],
            },
            {
                path: "/users",
                name: "all users",
                meta: {
                    permissions: ["show users"],
                },
                component: () => import("./views/User/Index.vue"),
            },
            {
                path: "/user",
                children: [
                    {
                        path: "create",
                        name: "add user",
                        meta: {
                            permissions: ["create users"],
                        },
                        component: () => import("./views/User/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show user",
                        meta: {
                            permissions: ["show users"],
                        },
                        component: () => import("./views/User/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit user",
                        meta: {
                            permissions: ["update users"],
                        },
                        component: () => import("./views/User/Edit.vue"),
                    },
                ],
            },
            {
                path: "/roles",
                name: "all roles",
                meta: {
                    permissions: ["show roles"],
                },
                component: () => import("./views/Role/Index.vue"),
            },
            {
                path: "/role",
                children: [
                    {
                        path: "create",
                        name: "add role",
                        meta: {
                            permissions: ["create roles"],
                        },
                        component: () => import("./views/Role/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show role",
                        meta: {
                            permissions: ["show roles"],
                        },
                        component: () => import("./views/Role/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit role",
                        meta: {
                            permissions: ["update roles"],
                        },
                        component: () => import("./views/Role/Edit.vue"),
                    },
                ],
            },
            {
                path: "/permissions",
                name: "all permissions",
                meta: {
                    permissions: ["show permissions"],
                },
                component: () => import("./views/Permission/Index.vue"),
            },
            {
                path: "/permission",
                children: [
                    {
                        path: "create",
                        name: "add permission",
                        meta: {
                            permissions: ["create permissions"],
                        },
                        component: () =>
                            import("./views/Permission/Create.vue"),
                    },
                    {
                        path: ":id",
                        name: "show permission",
                        meta: {
                            permissions: ["show permissions"],
                        },
                        component: () => import("./views/Permission/Show.vue"),
                    },
                    {
                        path: ":id/edit",
                        name: "edit permission",
                        meta: {
                            permissions: ["update permissions"],
                        },
                        component: () => import("./views/Permission/Edit.vue"),
                    },
                ],
            },
        ],
    },
    {
        path: "/:pathMatch(.*)*",
        component: () => import("./views/PageNotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to) => {
    if (to.meta.middlewares) {
        for (let i = 0; i < to.meta.middlewares.length; i++) {
            if (to.meta.middlewares[i]() !== true) {
                return to.meta.middlewares[i]();
            }
        }
    }

    const authStore = useAuthStore();
    const { hasPermissions } = authStore;
    if (to.meta.permissions) {
        if (!hasPermissions(to.meta.permissions)) {
            return { name: "home" };
        }
    }
});

export default router;
