export default function sidebar() {
    return {
        isCollapsed: false,
        isActive: "",
        hoveredItem: "",
        isInitialized: false,

        toggleSidebar() {
            this.isCollapsed = !this.isCollapsed;
        },
        setHovered(item) {
            this.hoveredItem = item;
        },
        resetHovered() {
            this.hoveredItem = "";
        },
        init() {
            this.isInitialized = true;
        },
    };
}
