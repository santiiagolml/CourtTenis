
module.exports = ({ env }) => ({
    plugins: [
        require("tailwindcss")("./tailwind.config.js"),
        require("autoprefixer")()
    ],
});
