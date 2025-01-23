<div x-data="sidebar" :class="{ 'w-20': isCollapsed, 'w-64': !isCollapsed }" id="sidebar"
    class="bg-custom-red-bg text-white flex flex-col p-6 sidebar-transition relative">
    <a href="#" class="flex items-center mb-6">
        <img src="{{ asset('assets/image/Handbag.png') }}" alt="SIMS Logo" class="h-6">
        <h2 class="ml-2 text-2xl font-bold text-white" :class="{ 'hidden': isCollapsed }">SIMS Web App</h2>
    </a>

    <div class="sidebar-content">
        <ul :class="{ 'space-y-4': !isCollapsed, 'm-0': isCollapsed }" class="mt-6">
            @foreach ($dataSidebar as $item)
                <li class="sidebar-item group relative"
                    :class="{
                        'bg-custom-red-active-sidebar rounded-xl': isActive === '{{ $item['title'] }}',
                        'hover:bg-custom-red-active-sidebar rounded-xl': !isCollapsed
                    }">
                    <a href="#" @click="isActive = '{{ $item['title'] }}'"
                        class="flex items-center w-full text-lg font-medium text-white hover:text-gray-200 transition duration-200"
                        :class="{ 'p-3': !isCollapsed, 'py-3': isCollapsed, 'mx-1': isCollapsed }"
                        @mouseover="setHovered('{{ $item['title'] }}')" @mouseleave="resetHovered()">
                        <div class="flex items-center gap-2 w-full">
                            <img src="{{ asset('assets/image/' . $item['assets']) }}" alt="{{ $item['assets'] }} Icon"
                                class="h-6 icon">
                            <span class="text" :class="{ 'hidden': isCollapsed }">{{ ucfirst($item['title']) }}</span>
                        </div>
                    </a>

                    <div x-show="isCollapsed && hoveredItem === '{{ $item['title'] }}'"
                        class="absolute left-full top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-lg text-xs w-max"
                        x-transition:enter="transition transform ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        {{ ucfirst($item['title']) }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <button @click="toggleSidebar"
        class="sidebar-toggle absolute top-14 right-[-1.2rem] bg-red-600 rounded-full p-2 z-10 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'hidden': isCollapsed }" class="h-6 w-6" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'hidden': !isCollapsed }" class="h-6 w-6" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l6-6-6-6"></path>
        </svg>
    </button>
</div>
