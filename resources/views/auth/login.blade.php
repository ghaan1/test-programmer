<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMS Web App</title>
    @vite('resources/js/app.js')
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body class="font-sans antialiased" x-data="setupLogin" x-cloak x-init="init()">
    <div class="min-h-screen flex" x-show="true">
        <div class="w-full md:w-1/2 bg-white flex flex-col justify-center items-center p-8" x-data="setupLogin">
            <div class="max-w-sm w-full">
                <div class="flex items-center justify-center space-x-2 mb-5">
                    <img src="{{ asset('assets/image/Handbag.png') }}" alt="SIMS Logo" class="h-6"
                        style="filter: brightness(0) saturate(100%) invert(37%) sepia(87%) saturate(749%) hue-rotate(345deg) brightness(89%) contrast(89%);">
                    <h2 class="text-2xl font-bold text-black">SIMS Web App</h2>
                </div>
                <p class="text-black font-bold text-3xl text-center mb-12">Masuk atau buat akun untuk memulai</p>
                <form @submit.prevent="submitLogin">
                    @csrf
                    <div class="mb-8 relative">
                        <input type="email" id="email" name="email" x-model="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-red-button focus:border-custom-red-button pl-10"
                            placeholder="masukan email anda">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            @
                        </div>
                    </div>
                    <div class="mb-8 relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            x-model="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-red-button focus:border-custom-red-button pl-10"
                            placeholder="masukan password anda">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="17" height="17"
                                viewBox="0,0,256,256">
                                <g fill="#9ca3af" fill-rule="nonzero" stroke="none" stroke-width="1"
                                    stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                    stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                                    font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                    <g transform="scale(5.12,5.12)">
                                        <path
                                            d="M25,3c-6.63672,0 -12,5.36328 -12,12v5h-4c-1.64453,0 -3,1.35547 -3,3v24c0,1.64453 1.35547,3 3,3h32c1.64453,0 3,-1.35547 3,-3v-24c0,-1.64453 -1.35547,-3 -3,-3h-4v-5c0,-6.63672 -5.36328,-12 -12,-12zM25,5c5.56641,0 10,4.43359 10,10v5h-20v-5c0,-5.56641 4.43359,-10 10,-10zM9,22h32c0.55469,0 1,0.44531 1,1v24c0,0.55469 -0.44531,1 -1,1h-32c-0.55469,0 -1,-0.44531 -1,-1v-24c0,-0.55469 0.44531,-1 1,-1zM25,30c-1.69922,0 -3,1.30078 -3,3c0,0.89844 0.39844,1.6875 1,2.1875v2.8125c0,1.10156 0.89844,2 2,2c1.10156,0 2,-0.89844 2,-2v-2.8125c0.60156,-0.5 1,-1.28906 1,-2.1875c0,-1.69922 -1.30078,-3 -3,-3z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </div>

                        <button type="button" @click="togglePasswordVisibility"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <!-- Icon for password visibility toggle -->
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                version="1.1" id="fi_709612" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;"
                                xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="gray" d="M508.745,246.041c-4.574-6.257-113.557-153.206-252.748-153.206S7.818,239.784,3.249,246.035
                                            c-4.332,5.936-4.332,13.987,0,19.923c4.569,6.257,113.557,153.206,252.748,153.206s248.174-146.95,252.748-153.201
                                            C513.083,260.028,513.083,251.971,508.745,246.041z M255.997,385.406c-102.529,0-191.33-97.533-217.617-129.418
                                            c26.253-31.913,114.868-129.395,217.617-129.395c102.524,0,191.319,97.516,217.617,129.418
                                            C447.361,287.923,358.746,385.406,255.997,385.406z"></path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path fill="gray"
                                            d="M255.997,154.725c-55.842,0-101.275,45.433-101.275,101.275s45.433,101.275,101.275,101.275
                                            s101.275-45.433,101.275-101.275S311.839,154.725,255.997,154.725z M255.997,323.516c-37.23,0-67.516-30.287-67.516-67.516
                                            s30.287-67.516,67.516-67.516s67.516,30.287,67.516,67.516S293.227,323.516,255.997,323.516z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                viewBox="0 0 512 512">
                                <path fill="gray"
                                    d="m306.6 252.29 33.13 33.13c3.25-9.21 5.02-19.11 5.02-29.42 0-48.93-39.81-88.74-88.74-88.74-10.31 0-20.21 1.77-29.42 5.02l33.13 33.13c25.02 1.82 45.06 21.86 46.88 46.88z">
                                </path>
                                <path fill="gray"
                                    d="m118.82 386.29c42.6 23.72 89.43 36.23 135.55 36.23h1.64c32.23.22 64.8-5.71 96.06-17.28l40.85 40.85c3.71 3.71 8.57 5.57 13.44 5.57s9.73-1.86 13.44-5.57c7.42-7.42 7.42-19.45 0-26.87l-327.23-327.23c-7.42-7.42-19.45-7.42-26.87 0s-7.42 19.45 0 26.87l24.76 24.76c-31.56 22.41-59.44 50.99-81.73 83.99-11.64 17.25-11.64 39.54 0 56.8 28.75 42.57 66.82 77.8 110.08 101.89zm134.7-79.62c-26-1.27-46.91-22.18-48.18-48.18zm-213.29-57.81c20.98-31.07 47.51-57.67 77.54-77.94l54.82 54.82c-3.44 9.45-5.31 19.63-5.31 30.25 0 48.93 39.81 88.74 88.74 88.74 10.62 0 20.8-1.88 30.25-5.32l35.75 35.75c-21.23 6.17-42.9 9.35-64.35 9.35-.5 0-1.01 0-1.51 0h-.26c-40.19.27-81.15-10.59-118.58-31.42-38.08-21.2-71.65-52.31-97.07-89.95-2.93-4.34-2.93-9.94 0-14.27z">
                                </path>
                                <path fill="gray"
                                    d="m503.29 227.6c-28.75-42.57-66.82-77.8-110.08-101.89-42.6-23.72-89.43-36.23-135.56-36.23-.55 0-1.09 0-1.64 0s-1.09 0-1.64 0c-31.39 0-63.11 5.8-93.6 16.98l30.11 30.11c20.95-6 42.33-9.09 63.49-9.09h1.51.26c40.14-.3 81.15 10.59 118.58 31.42 38.08 21.2 71.65 52.31 97.07 89.95 2.93 4.34 2.93 9.94 0 14.27-20.83 30.84-47.12 57.28-76.87 77.49l27.29 27.29c31.29-22.34 58.94-50.75 81.07-83.52 11.64-17.25 11.64-39.54 0-56.79z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <button type="submit"
                        class="w-full bg-custom-red-button text-white font-bold text-sm py-2 rounded-md hover:bg-custom-red-bg focus:outline-none focus:ring-2 focus:ring-custom-red-bg">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
        <div class="right-column-login hidden md:block w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/image/Frame 98699.png') }}');">
        </div>
    </div>
</body>

</html>
