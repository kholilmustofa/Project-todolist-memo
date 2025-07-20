<nav class="w-70 flex flex-col h-full bg-black/60 backdrop-blur-sm z-10 overflow-y-auto"
     x-data="{}"> {{-- x-data kosong agar Alpine.js memproses elemen ini --}}
    <div class="flex gap-4 mt-10">
        <div class="flex-row">
            <div class="hidden sm:flex sm:ms-6">
                <x-dropdown align="left" width="50">
                    <x-slot name="trigger">
                        <div
                            class="ring-white ring-offset-base-100 w-10 rounded-full ring-1 ring-offset-1 items-center cursor-pointer">
                            <a class="w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M12.563 3.2h-1.126l-.645 2.578l-.647.2a6.3 6.3 0 0 0-1.091.452l-.599.317l-2.28-1.368l-.796.797l1.368 2.28l-.317.598a6.3 6.3 0 0 0-.453 1.091l-.199.647l-2.578.645v1.126l2.578.645l.2.647q.173.568.452 1.091l.317.599l-1.368 2.28l.797.796l2.28-1.368l.598.317q.523.278 1.091.453l.647.199l.645 2.578h1.126l.645-2.578l.647-.2a6.3 6.3 0 0 0 1.091-.452l.599-.317l2.28 1.368l.796-.797l-1.368-2.28l.317-.598q.278-.523.453-1.091l.199-.647l2.578-.645v-1.126l-2.578-.645l-.2-.647a6.3 6.3 0 0 0-.452-1.091l-.317-.599l1.368-2.28l-.797-.796l-2.28 1.368l-.598-.317a6.3 6.3 0 0 0-1.091-.453l-.647-.199zm2.945 2.17l1.833-1.1a1 1 0 0 1 1.221.15l1.018 1.018a1 1 0 0 1 .15 1.221l-1.1 1.833q.33.62.54 1.3l2.073.519a1 1 0 0 1 .757.97v1.438a1 1 0 0 1-.757.97l-2.073.519q-.21.68-.54 1.3l1.1 1.833a1 1 0 0 1-.15 1.221l-1.018 1.018a1 1 0 0 1-1.221.15l-1.833-1.1q-.62.33-1.3.54l-.519 2.073a1 1 0 0 1-.97.757h-1.438a1 1 0 0 1-.97-.757l-.519-2.073a7.5 7.5 0 0 1-1.3-.54l-1.833 1.1a1 1 0 0 1-1.221-.15L4.42 18.562a1 1 0 0 1-.15-1.221l1.1-1.833a7.5 7.5 0 0 1-.54-1.3l-2.073-.519A1 1 0 0 1 2 12.72v-1.438a1 1 0 0 1 .757-.97l2.073-.519q.21-.68.54-1.3L4.27 6.66a1 1 0 0 1 .15-1.221L5.438 4.42a1 1 0 0 1 1.221-.15l1.833 1.1q.62-.33 1.3-.54l.519-2.073A1 1 0 0 1 11.28 2h1.438a1 1 0 0 1 .97.757l.519 2.073q.68.21 1.3.54zM12 14.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8" />
                                </svg>
                            </a>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="flex-row">
            <p class="font-semibold">{{ Auth::user()->first_name }}</p>
            <p class="text-white/40">Let's Plan</p>
        </div>
    </div>
    {{-- nav menu --}}
    <div class="flex flex-col mt-7 ">
        <ul class="menu rounded-box w-64 gap-2 ">
            <li>
                <a href="/myday"
                    class="text-base font-normal {{ Request::is('myday') ? 'active text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-miterlimit="10"
                            stroke-width="1.5">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12s4.477 10 10 10Z" />
                            <path d="M12 18a6 6 0 1 0 0-12a6 6 0 0 0 0 12Z" />
                            <path d="M12 14a2 2 0 1 0 0-4a2 2 0 0 0 0 4Z" />
                        </g>
                    </svg>
                    My Day
                </a>
            </li>
            <li>
                <a href="/allmytasks"
                    class="text-base font-normal {{ Request::is('allmytasks') ? 'active text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M8.885 12.308h6.23q.213 0 .357-.144t.144-.357t-.144-.356t-.356-.143H8.885q-.213 0-.357.144q-.143.144-.143.356q0 .213.143.357t.357.143m0 2.769h6.23q.213 0 .357-.144t.144-.357t-.144-.356t-.356-.143H8.885q-.213 0-.357.144q-.143.144-.143.357t.143.356t.357.143m0 2.77h3.23q.213 0 .357-.145t.144-.356t-.144-.356t-.356-.144H8.885q-.213 0-.357.144q-.143.144-.143.357t.143.356t.357.143M6.615 21q-.69 0-1.152-.462T5 19.385V4.615q0-.69.463-1.152T6.616 3h7.213q.331 0 .632.13t.518.349L18.52 7.02q.217.218.348.518t.131.632v11.214q0 .69-.463 1.153T17.385 21zM18 8h-2.788q-.505 0-.859-.353Q14 7.293 14 6.789V4H6.616q-.231 0-.424.192T6 4.615v14.77q0 .23.192.423t.423.192h10.77q.23 0 .423-.192t.192-.424zM6 4v4zv16z" />
                    </svg>
                    All My Tasks
                </a>
            </li>
        </ul>
        <ul class="menu rounded-box w-64 gap-2 ">
            <li>
                <div class="menu-title flex justify-between">
                    <h2 class=" text-lg flex gap-1">My Lists </h2>
                    <a href="#" class="hover:text-white" @click.prevent="$store.globalStore.showAddListModal = true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2" />
                        </svg>
                    </a>
                </div>
                <ul>
                    <template x-for="list in $store.globalStore.mylists" :key="list.id">
                        <li>
                            <a :href="`/lists/${list.id}`" x-text="list.name" @click="$store.globalStore.showAddListModal = false"></a>
                        </li>
                    </template>
                </ul>
            </li>
        </ul>
    </div>
</nav>