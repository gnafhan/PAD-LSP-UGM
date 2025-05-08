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
                biru_muda: "#36B2E6",
                softLilac: "#EDE5FF",
                ungu: "#8B5CF6",
                biru_tua: "#52BAFF",
                btn_hover: "#F4F4F4",
                sidebar_font: "#616161",
                logout: "#EF5050",
                font_status: "#44479C",
                font_desc: "#687083",
                border_input: "#D2D2D2",
                placeholder_input: "#D9D9D9",
                abu: "#A8A8A9",
                hijau: "#35B636",
                hijau_muda: "#E3F6ED",
                font_hijau: "#489D72",
                font_abu:"#828282",
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
