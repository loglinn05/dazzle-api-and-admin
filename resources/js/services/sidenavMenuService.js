import { useAuthStore } from "../stores/authStore";

export const SidenavMenuService = {
    getTreeNodesData() {
        const authStore = useAuthStore();
        const { hasPermissions } = authStore;
        let allNodes = [
            {
                key: "0",
                label: "Products",
                data: "Manage products",
                icon: "pi pi-fw pi-shopping-bag",
                route: "/products",
                visible: true,
            },
            {
                key: "1",
                label: "Product features",
                data: "Manage product features",
                icon: "pi pi-fw pi-tags",
                visible: true,
                children: [
                    {
                        key: "1-0",
                        label: "Categories",
                        icon: "pi pi-fw pi-th-large",
                        data: "Manage categories",
                        route: "/categories",
                    },
                    {
                        key: "1-1",
                        label: "Subcategories",
                        icon: "pi pi-fw pi-th-large",
                        data: "Manage subcategories",
                        route: "/subcategories",
                    },
                    {
                        key: "1-2",
                        label: "Types",
                        icon: "pi pi-fw pi-th-large",
                        data: "Manage types",
                        route: "/types",
                    },
                    {
                        key: "1-3",
                        label: "Manufacturers",
                        icon: "pi pi-fw pi-building",
                        data: "Manage manufacturers",
                        route: "/manufacturers",
                    },
                    {
                        key: "1-4",
                        label: "Sizes",
                        icon: "pi pi-fw pi-tag",
                        data: "Manage sizes",
                        route: "/sizes",
                    },
                    {
                        key: "1-5",
                        label: "Colors",
                        icon: "pi pi-fw pi-palette",
                        data: "Manage colors",
                        route: "/colors",
                    },
                    {
                        key: "1-6",
                        label: "Materials",
                        icon: "pi pi-fw pi-tag",
                        data: "Manage materials",
                        route: "/materials",
                    },
                    {
                        key: "1-7",
                        label: "Seasons",
                        icon: "pi pi-fw pi-sun",
                        data: "Manage seasons",
                        route: "/seasons",
                    },
                ],
            },
            {
                key: "2",
                label: "Orders",
                data: "Manage orders",
                icon: "pi pi-fw pi-truck",
                visible: true,
            },
            {
                key: "3",
                label: "Users",
                data: "Manage users",
                icon: "pi pi-fw pi-user",
                route: "/users",
                visible: true,
            },
            {
                key: "4",
                label: "Roles",
                data: "Manage roles",
                icon: "pi pi-fw pi-key",
                route: "/roles",
                visible: hasPermissions(["show roles"]),
            },
            {
                key: "5",
                label: "Permissions",
                data: "Manage permissions",
                icon: "pi pi-fw pi-lock",
                route: "/permissions",
                visible: hasPermissions(["show permissions"]),
            },
        ];
        let filteredNodes = allNodes.filter((node) => {
            if (node.visible) {
                return node;
            }
        });
        return filteredNodes;
    },

    getTreeNodes() {
        return Promise.resolve(this.getTreeNodesData());
    },
};
