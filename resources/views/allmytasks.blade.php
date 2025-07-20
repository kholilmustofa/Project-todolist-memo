<x-app-layout>
    <div class="flex flex-col w-full h-full p-5"
         x-data="{
             init() {
                 $store.globalStore.setCurrentPage('allmytasks');
             }
         }">

        {{-- header --}}
        <div class="flex-1 w-45 mb-8 h-full">
            <div class="col-span-6">
                <h1 class="text-lg font-semibold bg-neutral-800 rounded-4xl pt-3 pb-3 text-center">All My Tasks</h1>
            </div>
        </div>

        {{-- content --}}
        <div class="flex w-full gap-5 mb-10">

            {{-- Panel Kiri (Daftar Task) --}}
            <div class="w-full max-w-xl bg-neutral-900 rounded-2xl h-full flex flex-col">
                {{-- Task --}}
                <div class="flex-1 overflow-y-auto scroll-smooth min-h-130 max-h-130 p-6">
                    {{-- Today Section --}}
                    <details class="mb-4" :open="$store.globalStore.openSection === 'today'">
                        <summary @click.prevent="$store.globalStore.openSection = ($store.globalStore.openSection === 'today' ? null : 'today')"
                            class="flex items-center justify-between w-full text-lg font-semibold mb-2 cursor-pointer select-none">
                            <span :class="$store.globalStore.openSection === 'today' ? 'text-primary' : ''">Today</span>
                            <span
                                class="badge badge-lg bg-neutral-400 text-neutral-900 rounded-full w-7 h-7 flex items-center justify-center text-sm"
                                x-text="$store.globalStore.tasks.today.length"></span>
                        </summary>
                        <ul class="menu menu-md w-full mt-2 gap-2">
                            <template x-for="task in $store.globalStore.tasks.today" :key="task.id">
                                <li class="flex items-center w-full">
                                    <a href="#" class="flex items-center justify-between w-full"
                                        @click.prevent="$store.globalStore.selectTask(task)"
                                        :class="$store.globalStore.selectedTask && $store.globalStore.selectedTask.id === task.id ?
                                            'bg-neutral-800 text-white' :
                                            ''">
                                        <div class="flex gap-4 items-center">
                                            <input type="checkbox"
                                                class="checkbox checkbox-primary border-neutral-400 bg-neutral-900 checkbox-sm"
                                                x-model="task.completed"
                                                @change="$store.globalStore.toggleTaskCompletion(task.id, $event.target.checked)"
                                                @click.stop>
                                            <div class="flex flex-col text-sm">
                                                <span :class="{ 'line-through text-gray-500': task.completed }"
                                                    x-text="task.name"></span>

                                                {{-- Grup untuk MyList dan Waktu Reminder --}}
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-500"
                                                        x-text="$store.globalStore.getListName(task.mylist_id)"></span>
                                                    <span class="text-gray-500 ml-1"
                                                        x-text="$store.globalStore.formatRemindTime(task)"></span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- tombol hapus --}}
                                        <button x-show="task.completed"
                                            class="btn btn-xs btn-ghost rounded-full text-red-500 hover:bg-red-500 hover:text-white"
                                            @click.prevent.stop="$store.globalStore.deleteTask(task.id)" title="Delete Task">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" d="M6 6l12 12M6 18L18 6" />
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            </template>
                            <template x-if="$store.globalStore.tasks.today.length === 0">
                                <li><a class="text-gray-500">There are no assignments for today.</a></li>
                            </template>
                        </ul>
                    </details>

                    {{-- Tomorrow Section --}}
                    <details class="mb-4" :open="$store.globalStore.openSection === 'tomorrow'">
                        <summary @click.prevent="$store.globalStore.openSection = ($store.globalStore.openSection === 'tomorrow' ? null : 'tomorrow')"
                            class="flex items-center justify-between w-full text-lg font-semibold mb-2 cursor-pointer select-none">
                            <span :class="$store.globalStore.openSection === 'tomorrow' ? 'text-primary' : ''">Tomorrow</span>
                            <span
                                class="badge badge-lg bg-neutral-400 text-neutral-900 rounded-full w-7 h-7 flex items-center justify-center text-sm"
                                x-text="$store.globalStore.tasks.tomorrow.length"></span>
                        </summary>
                        <ul class="menu menu-lg text-sm w-full mt-2 gap-2">
                            <template x-for="task in $store.globalStore.tasks.tomorrow" :key="task.id">
                                <li>
                                    <a href="#" @click.prevent="$store.globalStore.selectTask(task)"
                                        :class="$store.globalStore.selectedTask && $store.globalStore.selectedTask.id === task.id ?
                                            'bg-neutral text-white' : ''">
                                        <input type="checkbox"
                                            class="checkbox border-neutral-500 bg-neutral-900 checkbox-sm"
                                            x-model="task.completed"
                                            @change="$store.globalStore.toggleTaskCompletion(task.id, $event.target.checked)" @click.stop>
                                        <div class="flex flex-col text-sm">
                                            <span :class="{ 'line-through text-gray-500': task.completed }"
                                                x-text="task.name"></span>

                                            {{-- Grup untuk MyList dan Waktu Reminder --}}
                                            <div class="flex items-center text-xs">
                                                <span class="text-gray-500" x-text="$store.globalStore.getListName(task.mylist_id)"></span>
                                                <p class="text-gray-500 ml-1"> | </p>
                                                <span class="text-gray-500 ml-1" x-text="$store.globalStore.formatRemindTime(task)"></span>
                                            </div>
                                        </div>
                                        {{-- tombol hapus --}}
                                        <button x-show="task.completed"
                                            class="btn btn-xs btn-ghost rounded-full text-red-500 hover:bg-red-500 hover:text-white"
                                            @click.prevent.stop="$store.globalStore.deleteTask(task.id)" title="Delete Task">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" d="M6 6l12 12M6 18L18 6" />
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            </template>
                            <template x-if="$store.globalStore.tasks.tomorrow.length === 0">
                                <li><a class="text-gray-500 text-sm">There is no assignment for tomorrow.</a></li>
                            </template>
                        </ul>
                    </details>

                    {{-- Upcoming Section --}}
                    <details class="mb-4" :open="$store.globalStore.openSection === 'upcoming'">
                        <summary @click.prevent="$store.globalStore.openSection = ($store.globalStore.openSection === 'upcoming' ? null : 'upcoming')"
                            class="flex items-center justify-between w-full text-lg font-semibold mb-2 cursor-pointer select-none">
                            <span :class="$store.globalStore.openSection === 'upcoming' ? 'text-primary' : ''">Upcoming</span>
                            <span
                                class="badge badge-lg bg-neutral-400 text-neutral-900 rounded-full w-7 h-7 flex items-center justify-center text-sm"
                                x-text="$store.globalStore.tasks.upcoming.length"></span>
                        </summary>
                        <ul class="menu menu-lg text-sm w-full mt-2 gap-2">
                            <template x-for="task in $store.globalStore.tasks.upcoming" :key="task.id">
                                <li>
                                    <a href="#" @click.prevent="$store.globalStore.selectTask(task)"
                                        :class="$store.globalStore.selectedTask && $store.globalStore.selectedTask.id === task.id ?
                                            'bg-neutral text-white' : ''">
                                        <input type="checkbox"
                                            class="checkbox border-neutral-400 bg-neutral-900 checkbox-sm"
                                            x-model="task.completed"
                                            @change="$store.globalStore.toggleTaskCompletion(task.id, $event.target.checked)" @click.stop>
                                        <div class="flex flex-col text-sm">
                                            <span :class="{ 'line-through text-gray-500': task.completed }"
                                                x-text="task.name"></span>

                                            {{-- Grup untuk MyList dan Waktu Reminder --}}
                                            <div class="flex items-center text-xs">
                                                <span class="text-gray-500"
                                                    x-text="$store.globalStore.getListName(task.mylist_id)"></span>
                                                <p class="text-gray-500 ml-1"> | </p>
                                                <span class="text-gray-500 ml-1"
                                                    x-text="$store.globalStore.formatRemindTime(task)"></span>
                                            </div>
                                        </div>
                                        {{-- tombol hapus --}}
                                        <button x-show="task.completed"
                                            class="btn btn-xs btn-ghost rounded-full text-red-500 hover:bg-red-500 hover:text-white"
                                            @click.prevent.stop="$store.globalStore.deleteTask(task.id)" title="Delete Task">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" d="M6 6l12 12M6 18L18 6" />
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            </template>
                            <template x-if="$store.globalStore.tasks.upcoming.length === 0">
                                <li><a class="text-gray-500 text-sm">There are no upcoming assignments.</a></li>
                            </template>
                        </ul>
                    </details>
                </div>

                {{-- Dropup dan form addtask --}}
                <div class="py-3 px-5 bg-neutral-800 shadow-[0_-35px_60px_-15px_rgba(0,0,0,0.8)] rounded-b-2xl relative"
                    @click.away="$store.globalStore.showDropup = false">
                    {{-- Dropup content --}}
                    <div x-show="$store.globalStore.showDropup" x-transition:enter="transition ease-out duration-200" x-cloak
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute bottom-full left-0 right-0 p-3 bg-neutral-800 flex items-center justify-center gap-20 rounded-t-lg">
                        {{-- Logo Mylist --}}
                        <div class="dropdown dropdown-top">
                            <div tabindex="0" role="button"
                                class="btn btn-ghost bg-neutral-800 border-neutral-800 btn-circle min-w-[48px] flex items-center justify-center">
                                <template x-if="$store.globalStore.selectedMylistId === null">
                                    {{-- Default: SVG Personal --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" class="stroke-neutral-600 hover:stroke-primary">
                                        <g fill="none" stroke="" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5">
                                            <rect width="15" height="18.5" x="4.5" y="2.75" rx="3.5" />
                                            <path d="M8.5 6.755h7m-7 4h7m-7 4H12" />
                                        </g>
                                    </svg>
                                </template>
                                <template x-if="$store.globalStore.selectedMylistId !== null">
                                    <span class="font-semibold text-sm text-primary"
                                        x-text="$store.globalStore.mylists.find(l => l.id === $store.globalStore.selectedMylistId)?.name"
                                        @dblclick="$store.globalStore.selectedMylistId = null"></span>
                                </template>
                            </div>
                            <ul tabindex="0"
                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-60">
                                <template x-for="list in $store.globalStore.mylists" :key="list.id">
                                    <li>
                                        <a @click.prevent="$store.globalStore.selectedMylistId = list.id"
                                            :class="{ 'bg-primary text-white': $store.globalStore.selectedMylistId === list.id }">
                                            <span x-text="list.name"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <p class="text-2xl font-reguler text-neutral-700">|</p>
                        {{-- Logo remind me --}}
                        <div>
                            <template x-if="!$store.globalStore.newTaskRemind">
                                <a href="#" @click.prevent="$store.globalStore.openRemindModalWithDefaults(null)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 512 512" class="fill-neutral-600 hover:fill-primary">
                                        <path fill-rule="evenodd"
                                            d="M298.667 384c0 23.564-19.103 42.667-42.667 42.667S213.333 407.564 213.333 384zM256 42.667c-82.56 0-149.333 76.373-149.333 170.667v48.853L64 384h106.667c0 47.129 38.205 85.334 85.333 85.334s85.333-38.205 85.333-85.334H448l-42.667-121.813V219.52c0-80.853-47.146-154.88-116.266-170.666A138.7 138.7 0 0 0 256 42.667M124.16 341.334l22.827-64l2.346-7.894v-56.106c0-70.614 47.787-128 106.667-128a94 94 0 0 1 22.827 2.773c47.786 11.733 83.84 67.84 83.84 130.347v50.986l2.346 6.827l22.827 65.067z" />
                                    </svg>
                                </a>
                            </template>
                            <template x-if="$store.globalStore.newTaskRemind">
                                <div class="text-sm text-primary" @click="$store.globalStore.openRemindModalWithDefaults(null)">
                                    <span x-text="new Date($store.globalStore.newTaskRemind).toLocaleDateString()"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- form addtask --}}
                    <fieldset class="fieldset">
                        <input type="text"
                            class="input text-lg focus:outline-none focus:border-primary bg-neutral-700 input-md w-full"
                            placeholder="Add Task" x-model="$store.globalStore.newTaskName"
                            @focus="$store.globalStore.showDropup = true"
                            @keydown.enter.prevent="$store.globalStore.addTask()" />
                    </fieldset>
                </div>
            </div>

            {{-- Panel Kanan (Detail Task) --}}
            <template x-if="$store.globalStore.selectedTask">
                <div class="w-full max-w-xl bg-base-100 rounded-2xl flex flex-col">
                    <div class="flex-1 p-5">
                        <div>
                            <div class="flex items-center justify-start gap-2 text-gray-600 my-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.8"
                                        d="M7 6h14M7 12h14M7 18h14M3 18" />
                                </svg>
                                <a class="flex items-center gap-2">
                                    <p class="font-regular text-sm">My Lists</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="12"
                                        viewBox="0 0 12 24">
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M10.157 12.711L4.5 18.368l-1.414-1.414l4.95-4.95l-4.95-4.95L4.5 5.64l5.657 5.657a1 1 0 0 1 0 1.414" />
                                    </svg>
                                    <p class="font-regular text-sm"
                                        x-text="$store.globalStore.selectedTask.mylist ? $store.globalStore.selectedTask.mylist.name : 'Personal'"></p>
                                </a>
                            </div>
                            <div class="flex items-center justify-start p-2 mb-3">
                                <input
                                    type="text"
                                    class="input text-2xl border-none font-semibold focus:outline-none focus:border-none bg-transparent w-full"
                                    x-model="$store.globalStore.selectedTask.name"
                                    @blur="$store.globalStore.updateTaskName($store.globalStore.selectedTask.id, $event.target.value)"
                                />
                            </div>
                            <div class="flex items-center justify-start gap-3 mb-3">
                                {{-- Update Remind me --}}
                                <template x-if="!$store.globalStore.selectedTask.remind_at">
                                    <a href="#"
                                        @click.prevent="$store.globalStore.openRemindModalWithDefaults($store.globalStore.selectedTask)"
                                        class="btn bg-base-300 rounded-4xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <g fill="none" stroke="#f00" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.8">
                                                <g>
                                                    <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 3v2">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            dur="0.2s" values="4;0" />
                                                    </path>
                                                    <path stroke-dasharray="28" stroke-dashoffset="28"
                                                        d="M12 5c-3.31 0 -6 2.69 -6 6l0 6c-1 0 -2 1 -2 2h8M12 5c3.31 0 6 2.69 6 6l0 6c1 0 2 1 2 2h-8">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            begin="0.2s" dur="0.4s" values="28;0" />
                                                    </path>
                                                    <animateTransform fill="freeze" attributeName="transform"
                                                        begin="0.9s" dur="6s" keyTimes="0;0.05;0.15;0.2;1"
                                                        type="rotate" values="0 12 3;3 12 3;-3 12 3;0 12 3;0 12 3" />
                                                </g>
                                                <path stroke-dasharray="8" stroke-dashoffset="8"
                                                    d="M10 20c0 1.1 0.9 2 2 2c1.1 0 2 -0.9 2 -2">
                                                    <animate fill="freeze" attributeName="stroke-dashoffset"
                                                        begin="0.6s" dur="0.2s" values="8;0" />
                                                    <animateTransform fill="freeze" attributeName="transform"
                                                        begin="1.1s" dur="6s" keyTimes="0;0.05;0.15;0.2;1"
                                                        type="rotate" values="0 12 8;6 12 8;-6 12 8;0 12 8;0 12 8" />
                                                </path>
                                            </g>
                                        </svg>
                                        <p class="font-medium">Remind me</p>
                                    </a>
                                </template>
                                <template x-if="$store.globalStore.selectedTask.remind_at">
                                    <a href="#"
                                        @click.prevent="$store.globalStore.openRemindModalWithDefaults($store.globalStore.selectedTask)"
                                        class="btn bg-base-300 text-sm rounded-4xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <g fill="none" stroke="#f00" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.8">
                                                <g>
                                                    <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 3v2">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            dur="0.2s" values="4;0" />
                                                    </path>
                                                    <path stroke-dasharray="28" stroke-dashoffset="28"
                                                        d="M12 5c-3.31 0 -6 2.69 -6 6l0 6c-1 0 -2 1 -2 2h8M12 5c3.31 0 6 2.69 6 6l0 6c1 0 2 1 2 2h-8">
                                                        <animate fill="freeze" attributeName="stroke-dashoffset"
                                                            begin="0.2s" dur="0.4s" values="28;0" />
                                                    </path>
                                                    <animateTransform fill="freeze" attributeName="transform"
                                                        begin="0.9s" dur="6s" keyTimes="0;0.05;0.15;0.2;1"
                                                        type="rotate" values="0 12 3;3 12 3;-3 12 3;0 12 3;0 12 3" />
                                                </g>
                                                <path stroke-dasharray="8" stroke-dashoffset="8"
                                                    d="M10 20c0 1.1 0.9 2 2 2c1.1 0 2 -0.9 2 -2">
                                                    <animate fill="freeze" attributeName="stroke-dashoffset"
                                                        begin="0.6s" dur="0.2s" values="8;0" />
                                                    <animateTransform fill="freeze" attributeName="transform"
                                                        begin="1.1s" dur="6s" keyTimes="0;0.05;0.15;0.2;1"
                                                        type="rotate" values="0 12 8;6 12 8;-6 12 8;0 12 8;0 12 8" />
                                                </path>
                                            </g>
                                        </svg>
                                        <span x-text="new Date($store.globalStore.selectedTask.remind_at).toLocaleDateString()"></span>
                                    </a>
                                </template>

                                {{-- Update Mylist --}}
                                <a href="#" class="btn bg-base-300 rounded-4xl"
                                    @click.prevent="$dispatch('open-move-modal', $store.globalStore.selectedTask)"> {{-- DISPATCH EVENT --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <g fill="none" stroke="#ffd800" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5">
                                            <rect width="15" height="18.5" x="4.5" y="2.75"
                                                rx="3.5" />
                                            <path d="M8.5 6.755h7m-7 4h7m-7 4H12" />
                                        </g>
                                    </svg>
                                    <p class="font-medium"
                                        x-text="$store.globalStore.selectedTask.mylist ? $store.globalStore.selectedTask.mylist.name : 'Personal'"></p>
                                </a>
                            </div>
                            <div class="flex flex-col w-full mt-2 gap-2">
                                <h1 class="text-md font-medium p-2 text-gray-400">NOTES</h1>
                                <textarea
                                    class="textarea textarea-md textarea-neutral focus:outline-primary w-full"
                                    x-model="$store.globalStore.selectedTask.notes"
                                    placeholder="Insert your note here"
                                    @blur="$store.globalStore.updateTaskNotes($store.globalStore.selectedTask.id, $event.target.value)"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
        </div>
    </div>
</x-app-layout>