<!DOCTYPE html>
<html lang="en" data-theme="dark" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>memo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-cover bg-center bg-no-repeat h-full bg-[url(/public/image/background3.jpg)] flex"
    x-data="{}" {{-- Body ini adalah komponen Alpine.js utama yang mendengarkan event --}} x-init="// Inisialisasi global store
    $store.globalStore.init();
    
    // DAFTARKAN SEMUA EVENT LISTENER GLOBAL DI SINI (x-init dari body)
    // Event listeners ini adalah untuk MENGUBAH state di globalStore
    // Berdasarkan event yang didispatch dari UI (navigation, myday, allmytasks)
    
    // Listeners untuk membuka modal:
    $el.addEventListener('open-add-list-modal', () => {
        $store.globalStore.showAddListModal = true;
    });
    $el.addEventListener('open-remind-modal', (e) => {
        $store.globalStore.openRemindModalWithDefaults(e.detail);
    });
    $el.addEventListener('open-move-modal', (e) => {
        $store.globalStore.selectedTaskForModal = e.detail;
        $store.globalStore.showMylistModal = true;
    });
    
    // Listeners untuk action setelah modal ditutup atau data diubah:
    window.addEventListener('reminder-set', (e) => {
        // Ketika reminder diset dari modal, panggil fungsi API di globalStore
        // Ini membedakan apakah itu untuk task baru (e.detail.task === null)
        // atau update task yang sudah ada
        if (e.detail.task === null) {
            $store.globalStore.newTaskRemind = `${e.detail.date} ${e.detail.time}`;
            // Tidak perlu panggil addTask di sini. addTask akan dipanggil dari form input.
        } else {
            $store.globalStore.updateTaskReminder(e.detail.task.id, e.detail.date, e.detail.time);
        }
    });
    window.addEventListener('update-mylist-action', (e) => { // Perubahan nama event
        // Ketika mylist diupdate dari modal, panggil fungsi API di globalStore
        $store.globalStore.updateMylist(e.detail.taskId, e.detail.mylistId);
    });
    
    // Listeners untuk refresh data di UI setelah operasi CRUD:
    window.addEventListener('task-added', () => {
        $store.globalStore.initializeData();
    });
    window.addEventListener('task-deleted', () => {
        $store.globalStore.initializeData();
    });
    window.addEventListener('task-updated', () => {
        $store.globalStore.initializeData();
    });
    window.addEventListener('mylists-updated', () => {
        // Anda bisa tambahkan logika UI spesifik di sini jika perlu setelah mylists diupdate
    });">

    @include('layouts.navigation')

    <main class="w-310 h-full scroll-smooth overflow-y-auto justify-center z-10">
        {{ $slot }}
    </main>

    {{-- Modal untuk Tambah List Baru --}}
    <div class="fixed inset-0 bg-black/55 flex items-center justify-center z-50"
        x-show="$store.globalStore.showAddListModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="bg-neutral-800 rounded-lg p-6 shadow-xl shadow-black w-150 h-55 relative"
            @click.away="$store.globalStore.showAddListModal = false">
            <button class="absolute top-5 right-5 text-gray-400 hover:text-white"
                @click="$store.globalStore.showAddListModal = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <input type="text" placeholder="Add a list title"
                class="w-full input input-xl bg-neutral-800 border-none focus:outline-none hover:border-none text-white font-bold mb-4 mt-10 text-3xl"
                x-model="$store.globalStore.newListName" @keydown.enter="$store.globalStore.addMylist()">
            <div class="flex justify-end mt-5">
                <button type="button" class="btn btn-primary rounded-3xl px-10"
                    @click="$store.globalStore.addMylist()">Continue</button>
            </div>
        </div>
    </div>

    {{-- Modal Remind Me --}}
    <div class="fixed inset-0 bg-black/55 flex items-center justify-center z-50"
        x-show="$store.globalStore.showRemindModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="bg-neutral-800 rounded-lg p-6 shadow-xl shadow-black w-150 h-75 relative"
            @click.away="$store.globalStore.showRemindModal = false">
            <button class="absolute top-5 right-5 text-gray-400 hover:text-white"
                @click="$store.globalStore.showRemindModal = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold mb-4">Set Reminder</h2>
            {{-- Form ini akan mendispatch event reminder-set --}}
            <form
                @submit.prevent="$dispatch('reminder-set', { date: $store.globalStore.remindDate, time: $store.globalStore.remindTime, task: $store.globalStore.selectedTaskForModal })">
                <label class="block mb-2 text-sm font-medium">Date</label>
                <input type="date" x-model="$store.globalStore.remindDate" class="input input-bordered w-full mb-4"
                    required>
                <label class="block mb-2 text-sm font-medium">Time</label>
                <input type="time" x-model="$store.globalStore.remindTime" class="input input-bordered w-full mb-4"
                    required>
                <div class="flex justify-end gap-2">
                    <button type="button" class="btn btn-ghost"
                        @click="$store.globalStore.showRemindModal = false">Cancel</button>
                    <button type="submit" class="btn btn-primary">Set Reminder</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Update Mylist --}}
    <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
        x-show="$store.globalStore.showMylistModal" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="bg-neutral-900 rounded-xl p-6 w-96 shadow-xl relative"
            @click.away="$store.globalStore.showMylistModal = false">
            <button class="absolute top-3 right-3 text-gray-400 hover:text-white"
                @click="$store.globalStore.showMylistModal = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold mb-4">Move to Mylist</h2>

            <ul class="space-y-2 bg-neutral-900">
                <template x-for="list in $store.globalStore.mylists" :key="list.id">
                    <li>
                        {{-- Ini akan mendispatch event update-mylist-action --}}
                        <a href="#" class="block px-4 py-2 rounded hover:bg-primary hover:text-white"
                            :class="$store.globalStore.selectedTaskForModal && $store.globalStore.selectedTaskForModal.mylist &&
                                $store.globalStore.selectedTaskForModal.mylist.id === list.id ?
                                'bg-primary text-white' : ''"
                            @click.prevent="$dispatch('update-mylist-action', { taskId: $store.globalStore.selectedTaskForModal.id, mylistId: list.id })">
                            <span x-text="list.name"></span>
                        </a>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('globalStore', {
                // ===== CENTRALIZED STATE =====
                tasks: {
                    today: [],
                    tomorrow: [],
                    upcoming: []
                },
                mylists: [],
                selectedTask: null,
                openSection: 'today',

                // Form States
                newTaskName: '',
                selectedMylistId: null,
                newTaskRemind: null,
                showDropup: false,

                // Modal States
                showAddListModal: false,
                newListName: '',
                showRemindModal: false,
                remindDate: '',
                remindTime: '',
                showMylistModal: false,
                selectedTaskForModal: null,

                // API Configuration
                taskApiUrl: '{{ url('/tasks') }}',
                mylistsApiUrl: '{{ route('mylists.index') }}',
                csrfToken: '{{ csrf_token() }}',

                // Current Page State
                currentPage: 'myday',
                today: null,

                // ===== INITIALIZATION =====
                init() {
                    this.today = new Date();
                    this.initializeData();
                    setInterval(() => {
                        this.today = new Date();
                    }, 60 * 60 * 1000);
                },

                async initializeData() {
                    try {
                        await this.fetchMyLists();
                        await this.fetchAllTasks();

                        if (this.selectedTask) {
                            const found = this.findTask(this.selectedTask.id).task;
                            if (!found) {
                                this.selectedTask = null;
                            }
                        }
                    } catch (error) {
                        console.error('Error initializing data:', error);
                    }
                },

                // ===== API FUNCTIONS =====
                async fetchMyLists() {
                    try {
                        const response = await fetch(this.mylistsApiUrl);
                        if (!response.ok) throw new Error('Failed to fetch my lists.');
                        this.mylists = await response.json();
                        window.dispatchEvent(new CustomEvent('mylists-updated', {
                            detail: this.mylists
                        }));
                    } catch (error) {
                        console.error('Error fetching my lists:', error);
                    }
                },

                async fetchAllTasks() {
                    try {
                        const response = await fetch(this.taskApiUrl);
                        if (!response.ok) throw new Error('Failed to fetch tasks.');

                        const data = await response.json();
                        this.categorizeTasks(data);
                    } catch (error) {
                        console.error('Error fetching all tasks:', error);
                        this.tasks = {
                            today: [],
                            tomorrow: [],
                            upcoming: []
                        };
                    }
                },

                // ===== TASK MANAGEMENT =====
                async addTask() {
                    if (this.newTaskName.trim() === '') {
                        alert('Nama task tidak boleh kosong.');
                        return;
                    }

                    let mylistId = this.selectedMylistId;
                    if (!mylistId) {
                        const personalList = this.mylists.find(list => list.name === 'Personal');
                        if (!personalList && this.mylists.length > 0) {
                            mylistId = this.mylists[0].id;
                        } else if (personalList) {
                            mylistId = personalList.id;
                        } else {
                            alert('Tidak ada list yang tersedia. Silakan buat list terlebih dahulu.');
                            return;
                        }
                    }

                    const dueDate = this.newTaskRemind ?
                        this.newTaskRemind.split(' ')[0] :
                        new Date().toISOString().slice(0, 10);

                    const remindAt = this.newTaskRemind ? `${this.newTaskRemind}:00` : null;

                    try {
                        const response = await fetch(this.taskApiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: this.newTaskName,
                                completed: false,
                                due_date: dueDate,
                                mylist_id: mylistId,
                                remind_at: remindAt,
                                client_timestamp: Date.now()
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            const errorMessage = Object.values(errorData.errors)[0][0] || errorData
                                .message || 'Gagal menambah task.';
                            throw new Error(errorMessage);
                        }

                        const newTask = await response.json();
                        this.addTaskToSection(newTask);
                        this.resetTaskForm();
                        window.dispatchEvent(new CustomEvent('task-added', {
                            detail: newTask
                        }));

                    } catch (error) {
                        alert(`Error: ${error.message}`);
                        console.error('Error adding task:', error);
                    }
                },

                async toggleTaskCompletion(taskId, newCompletedStatus) {
                    const {
                        task,
                        section
                    } = this.findTask(taskId);
                    if (!task) return;

                    const originalStatus = task.completed;
                    task.completed = newCompletedStatus;

                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                completed: newCompletedStatus
                            })
                        });

                        if (!response.ok) {
                            throw new Error(
                                `Failed to update task completion. Status: ${response.status}.`);
                        }

                        const updatedTask = await response.json();
                        this.relocateTask(updatedTask);
                        window.dispatchEvent(new CustomEvent('task-updated', {
                            detail: updatedTask
                        }));

                    } catch (error) {
                        console.error('Error toggling task completion:', error);
                        alert('Failed to update task: ' + error.message);
                        task.completed = originalStatus;
                    }
                },

                async deleteTask(taskId) {
                    const {
                        task,
                        section,
                        index
                    } = this.findTask(taskId);
                    if (!task) return;

                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`Failed to delete task. Status: ${response.status}.`);
                        }

                        this.tasks[section].splice(index, 1);
                        if (this.selectedTask && this.selectedTask.id === taskId) {
                            this.selectedTask = null;
                        }
                        window.dispatchEvent(new CustomEvent('task-deleted', {
                            detail: taskId
                        }));

                    } catch (error) {
                        console.error('Error deleting task:', error);
                        alert('Failed to delete task: ' + error.message);
                    }
                },

                async updateTaskReminder(taskId, remindDate, remindTime) {
                    const remindAt = `${remindDate} ${remindTime}:00`;

                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                remind_at: remindAt,
                                due_date: remindDate
                            })
                        });

                        if (!response.ok) throw new Error('Gagal memperbarui reminder.');

                        const updatedTask = await response.json();
                        this.selectedTask = updatedTask;
                        this.relocateTask(updatedTask);
                        window.dispatchEvent(new CustomEvent('task-updated', {
                            detail: updatedTask
                        }));

                    } catch (error) {
                        alert(error.message);
                    }
                },

                // Ini adalah fungsi API yang dipanggil dari handleMylistUpdateModalLogic
                async updateMylist(taskId, newMylistId) {
                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                mylist_id: newMylistId
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Gagal update mylist');
                        }

                        const updatedTask = await response.json();
                        this.selectedTask = updatedTask;
                        this.relocateTask(updatedTask);
                        window.dispatchEvent(new CustomEvent('task-updated', {
                            detail: updatedTask
                        }));

                    } catch (error) {
                        alert(error.message);
                    }
                },

                async updateTaskNotes(taskId, newNotes) {
                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                notes: newNotes
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`Failed to update task notes. Status: ${response.status}.`);
                        }

                        const updatedTask = await response.json();
                        // Update task di state lokal agar UI ter-refresh
                        // Anda mungkin perlu mencari task berdasarkan ID dan memperbarui properti notesnya
                        const {
                            task,
                            section,
                            index
                        } = this.findTask(taskId);
                        if (task) {
                            this.tasks[section][index].notes = updatedTask.notes;
                            this.selectedTask.notes = updatedTask
                                .notes; // Pastikan selectedTask juga terupdate
                        }
                        window.dispatchEvent(new CustomEvent('task-updated', {
                            detail: updatedTask
                        }));

                    } catch (error) {
                        console.error('Error updating task notes:', error);
                        alert('Failed to update notes: ' + error.message);
                    }
                },

                async updateTaskName(taskId, newName) {
                    try {
                        const response = await fetch(`${this.taskApiUrl}/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: newName
                            }) // Mengirim 'name'
                        });

                        if (!response.ok) {
                            throw new Error(`Failed to update task name. Status: ${response.status}.`);
                        }

                        const updatedTask = await response.json();
                        // Update task di state lokal agar UI ter-refresh
                        const {
                            task,
                            section,
                            index
                        } = this.findTask(taskId);
                        if (task) {
                            this.tasks[section][index].name = updatedTask.name;
                            this.selectedTask.name = updatedTask
                            .name; // Pastikan selectedTask juga terupdate
                        }
                        window.dispatchEvent(new CustomEvent('task-updated', {
                            detail: updatedTask
                        }));

                    } catch (error) {
                        console.error('Error updating task name:', error);
                        alert('Failed to update task name: ' + error.message);
                    }
                },

                // ===== MYLIST MANAGEMENT =====
                async addMylist() {
                    if (this.newListName.trim() === '') {
                        alert('Nama daftar tidak boleh kosong.');
                        return;
                    }

                    try {
                        const response = await fetch('{{ route('mylists.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken
                            },
                            body: JSON.stringify({
                                name: this.newListName
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Failed to add list.');
                        }

                        const newList = await response.json();
                        this.mylists.push(newList);
                        this.newListName = '';
                        this.showAddListModal = false;
                        alert('Daftar berhasil ditambahkan!');
                        window.dispatchEvent(new CustomEvent('mylists-updated', {
                            detail: this.mylists
                        }));

                    } catch (error) {
                        console.error('Error adding list:', error);
                        alert('Gagal menambahkan daftar: ' + error.message);
                    }
                },

                // ===== UTILITY FUNCTIONS =====
                addTaskToSection(task) {
                    const todayString = new Date().toISOString().slice(0, 10);
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowString = tomorrow.toISOString().slice(0, 10);

                    let targetSection;
                    if (task.due_date && task.due_date.slice(0, 10) === todayString) {
                        targetSection = 'today';
                    } else if (task.due_date && task.due_date.slice(0, 10) === tomorrowString) {
                        targetSection = 'tomorrow';
                    } else {
                        targetSection = 'upcoming';
                    }

                    if (!this.tasks[targetSection]) {
                        this.tasks[targetSection] = [];
                    }
                    if (!this.tasks[targetSection].some(t => t.id === task.id)) {
                        this.tasks[targetSection].unshift(task);
                        this.tasks[targetSection] = this.sortTasks(this.tasks[targetSection]);
                    }
                },

                relocateTask(updatedTask) {
                    ['today', 'tomorrow', 'upcoming'].forEach(section => {
                        this.tasks[section] = this.tasks[section].filter(t => t.id !== updatedTask
                            .id);
                    });
                    this.addTaskToSection(updatedTask);
                },

                findTask(taskId) {
                    for (const section of ['today', 'tomorrow', 'upcoming']) {
                        const taskIndex = this.tasks[section].findIndex(t => t.id === taskId);
                        if (taskIndex !== -1) {
                            return {
                                task: this.tasks[section][taskIndex],
                                section: section,
                                index: taskIndex
                            };
                        }
                    }
                    return {
                        task: null,
                        section: null,
                        index: -1
                    };
                },

                sortTasks(taskList) {
                    return [...taskList].sort((a, b) => {
                        if (!a.completed && b.completed) return -1;
                        if (a.completed && !b.completed) return 1;
                        return b.id - a.id;
                    });
                },

                categorizeTasks(tasks) {
                    const todayString = new Date().toISOString().slice(0, 10);
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    const tomorrowString = tomorrow.toISOString().slice(0, 10);

                    this.tasks = {
                        today: [],
                        tomorrow: [],
                        upcoming: []
                    };

                    tasks.forEach(task => {
                        const taskDate = task.due_date ? task.due_date.slice(0, 10) : '';
                        if (taskDate === todayString) {
                            this.tasks.today.push(task);
                        } else if (taskDate === tomorrowString) {
                            this.tasks.tomorrow.push(task);
                        } else {
                            this.tasks.upcoming.push(task);
                        }
                    });

                    Object.keys(this.tasks).forEach(section => {
                        this.tasks[section] = this.sortTasks(this.tasks[section]);
                    });
                },

                resetTaskForm() {
                    this.newTaskName = '';
                    this.selectedMylistId = null;
                    this.newTaskRemind = null;
                    this.showDropup = false;
                },

                // ===== UI HELPERS (Fungsi yang dipanggil dari template UI) =====
                selectTask(task) {
                    this.selectedTask = task;
                },

                // Fungsi ini dipanggil saat form reminder disubmit
                // INI BUKAN API CALL, TAPI LOGIKA UNTUK MENANGANI SUBMIT MODAL
                handleReminderSubmit() {
                    // Logika untuk task baru vs. update task lama
                    if (this.selectedTaskForModal === null) {
                        // Jika ini untuk task baru, atur newTaskRemind.
                        // addTask() akan membaca nilai ini saat dipanggil dari form utama.
                        this.newTaskRemind = `${this.remindDate} ${this.remindTime}`;
                    } else {
                        // Jika ini untuk update task yang sudah ada, panggil fungsi API updateTaskReminder
                        this.updateTaskReminder(this.selectedTaskForModal.id, this.remindDate, this
                            .remindTime);
                    }
                    this.showRemindModal = false; // Tutup modal setelah submit
                },

                openRemindModalWithDefaults(task = null) {
                    this.selectedTaskForModal = task; // Set task yang akan diingatkan
                    const now = new Date();

                    let targetDate = new Date(now);
                    let targetHours = now.getHours();
                    let targetMinutes = now.getMinutes();

                    if (task === null) {
                        targetDate.setDate(now.getDate() + 1);
                        targetHours = 9;
                        targetMinutes = 0;
                    } else if (task.remind_at) {
                        const remindDateTime = new Date(task.remind_at);
                        targetDate = remindDateTime;
                        targetHours = remindDateTime.getHours();
                        targetMinutes = remindDateTime.getMinutes();
                    }

                    const year = targetDate.getFullYear();
                    const month = (targetDate.getMonth() + 1).toString().padStart(2, '0');
                    const day = targetDate.getDate().toString().padStart(2, '0');
                    this.remindDate = `${year}-${month}-${day}`;

                    this.remindTime =
                        `${targetHours.toString().padStart(2, '0')}:${targetMinutes.toString().padStart(2, '0')}`;

                    this.showRemindModal = true;
                },

                // Fungsi ini dipanggil dari template modal update mylist
                // INI BUKAN API CALL, TAPI LOGIKA UNTUK MENANGANI SUBMIT MODAL
                handleMylistUpdateModalLogic(
                    mylistId) { // Mengganti nama agar tidak sama dengan fungsi API `updateMylist`
                    // Langsung panggil fungsi API updateMylist dari sini
                    this.updateMylist(this.selectedTaskForModal.id, mylistId);
                    this.showMylistModal = false; // Tutup modal setelah update
                },

                getListName(listId) {
                    const list = this.mylists.find(l => l.id === listId);
                    return list ? list.name : 'Unknown List';
                },

                getGreeting() {
                    const hour = this.today ? this.today.getHours() : new Date().getHours();
                    if (hour >= 5 && hour < 12) return 'Good Morning';
                    if (hour >= 12 && hour < 15) return 'Good Afternoon';
                    if (hour >= 15 && hour < 18) return 'Good Evening';
                    return 'Good Night';
                },

                formatRemindTime(task) {
                    if (!task.remind_at) return '';

                    const remindDate = new Date(task.remind_at);
                    const now = new Date();
                    const todayString = now.toISOString().slice(0, 10);

                    const tomorrow = new Date(now);
                    tomorrow.setDate(now.getDate() + 1);
                    const tomorrowString = tomorrow.toISOString().slice(0, 10);

                    const taskDateString = remindDate.toISOString().slice(0, 10);
                    const timeString = remindDate.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    if (taskDateString === todayString) {
                        return `Today, ${timeString}`;
                    } else if (taskDateString === tomorrowString) {
                        return `Tomorrow, ${timeString}`;
                    } else {
                        return `${remindDate.toLocaleDateString()} ${timeString}`;
                    }
                },

                // ===== PAGE NAVIGATION =====
                setCurrentPage(page) {
                    this.currentPage = page;
                    this.initializeData();
                }
            });
        });
    </script>
</body>

</html>
