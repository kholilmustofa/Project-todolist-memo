<x-app-layout>
    <div class="grid grid-flow-col grid-rows-10 mx-60 h-full py-8 gap-3"
         x-data="{
             init() {
                 // Memberi tahu global store bahwa kita berada di halaman 'myday'
                 $store.globalStore.setCurrentPage('myday');
             }
         }">

        <div class="row-span-2 grid grid-cols-5 gap-3">
            <div class="col-span-4 flex flex-col justify-center items-center rounded-xl bg-black/70 backdrop-blur-md ">
                <h1 class="font-bold text-2xl ">
                    <span x-text="$store.globalStore.getGreeting()"></span>
                    <span class="text-primary">.</span>{{ Auth::user()->first_name }}
                </h1>
                <h1 class="font-bold text-2xl text-gray-400">This is your private space</h1>
            </div>

            <div class="col-span-1 flex flex-col items-center justify-center rounded-xl bg-black/60 backdrop-blur-sm ">
                <h1 class="text-lg font-medium text-gray-300"
                    x-text="$store.globalStore.today ? $store.globalStore.today.toLocaleDateString('en-US', { weekday: 'short' }).toUpperCase() : ''">
                </h1>
                <h1 class="text-5xl font-bold"
                    x-text="$store.globalStore.today ? $store.globalStore.today.getDate() : ''"></h1>
                <h1 class="text-lg font-medium text-gray-300"
                    x-text="$store.globalStore.today ? $store.globalStore.today.toLocaleDateString('en-US', { month: 'long' }).substring(0, 4).toUpperCase() : ''">
                </h1>
            </div>
        </div>

        <div class="w-full h-full row-span-7 scroll-smooth overflow-y-auto max-h-full">
            <ul class="menu menu-md w-full p-0 m-0 gap-2">
                <template x-for="task in $store.globalStore.tasks.today" :key="task.id">
                    <li class="p-0 m-0 gap-3">
                        <div
                            class="flex items-center justify-between p-6 font-normal bg-black/70 backdrop-blur-lg hover:bg-black/80 rounded-xl">
                            <div class="flex items-center flex-grow">
                                <input type="checkbox" class="checkbox checkbox-secondary bg-base-300 mr-4"
                                    :checked="task.completed"
                                    @change="$store.globalStore.toggleTaskCompletion(task.id, $event.target.checked)">
                                <span class="flex-grow" :class="{ 'line-through text-gray-500': task.completed }"
                                    x-text="task.name"></span>
                            </div>
                            <button x-show="task.completed"
                                @click="$store.globalStore.deleteTask(task.id)"
                                class="ml-4 btn btn-xs btn-circle btn-ghost text-red-500 hover:bg-red-500 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </li>
                </template>

                <template x-if="$store.globalStore.tasks.today.length === 0">
                    <li class="p-0 m-0 gap-3">
                        <div
                            class="block p-6 font-normal bg-black/60 backdrop-blur-lg rounded-xl text-center text-gray-400">
                            Ayo, tambahkan tugasmu
                        </div>
                    </li>
                </template>
            </ul>
        </div>

        <div class="w-full h-full rounded-xl row-span-1">
            <fieldset class="fieldset p-0 m-0">
                <input type="text"
                    class="input input-lg border-neutral-300 focus:border-primary focus:outline-none text-sm join-item w-full bg-black/60 backdrop-blur-xl"
                    placeholder="Add Task"
                    x-model="$store.globalStore.newTaskName"
                    @keydown.enter.prevent="$store.globalStore.addTask()">
            </fieldset>
        </div>
    </div>
</x-app-layout>