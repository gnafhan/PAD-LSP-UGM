module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        "./node_modules/flowbite-datepicker/**/*.js",
    ],
    theme: {
        darkMode: false,
        extend: {
            fontFamily: {
                inter: ["Inter", "sans-serif"],
                'bricolage': ["Bricolage Grotesque", "sans-serif"],
            },
            colors: {
                bg_dashboard: "#F9FAFB",
                border: "#E4E7EB",
                biru: "#53A4FF",
                biru_muda: "#36B2E6",
                biru_soft: "#E8F9FF",
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
                hijau_muda: "#EDFFEB",
                font_hijau: "#489D72",
                font_abu:"#828282",
                // Modern SaaS colors
                sky: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                }
            },
            animation: {
                'slide-in-left': 'slideInLeft 0.6s ease-out forwards',
                'slide-in-right': 'slideInRight 0.6s ease-out forwards',
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                'fade-in': 'fadeIn 0.6s ease-out forwards',
            },
            keyframes: {
                slideInLeft: {
                    '0%': { 
                        opacity: '0',
                        transform: 'translateX(-30px)'
                    },
                    '100%': { 
                        opacity: '1',
                        transform: 'translateX(0)'
                    }
                },
                slideInRight: {
                    '0%': { 
                        opacity: '0',
                        transform: 'translateX(30px)'
                    },
                    '100%': { 
                        opacity: '1',
                        transform: 'translateX(0)'
                    }
                },
                fadeInUp: {
                    '0%': { 
                        opacity: '0',
                        transform: 'translateY(20px)'
                    },
                    '100%': { 
                        opacity: '1',
                        transform: 'translateY(0)'
                    }
                },
                fadeIn: {
                    '0%': { 
                        opacity: '0'
                    },
                    '100%': { 
                        opacity: '1'
                    }
                }
            },
            boxShadow: {
                'medium': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'large': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            }
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
};
