module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.vue",
        './node_modules/flyonui/dist/js/*.js',
        "./node_modules/flowbite/**/*.js",
        "./node_modules/preline/dist/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                inter: ["Inter", "sans-serif"],
            },
            colors: {
                bg_dashboard: "#F9FAFB",
                border: "#E4E7EB",
                biru: "#53A4FF",
                softLilac: "#EDE5FF",
                ungu: "#8B5CF6",
                biru_tua: "#52BAFF",
                btn_hover: "#F4F4F4",
                sidebar_font: "#616161",
                logout: "#EF5050",
                fill_selesai: "#FAFFFA",
                font_selesai:"#52A14B",
                fill_progress: "#F8F7FF",
                font_progress: "#44479C",
                fill_pending: "#FFF2F2",
                font_pending: "#E05B5B",
                font_desc: "#687083",
                border_input: "#D2D2D2",
                placeholder_input: "#D9D9D9",
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('flyonui'),
        require('flyonui/plugin'),
        // require('preline/plugin'),
    ],
};
