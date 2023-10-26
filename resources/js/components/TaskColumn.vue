<template>
<div class="w-[300px] bg-sky-950 relative rounded-lg shadow-lg h-[75vh] overflow-auto scrollbar-hide">

    <div class="flex items-center justify-between sticky top-0 w-full px-3 py-4 bg-[#003049] z-10">
        <div class="flex items-center gap-1 text-lg text-zinc-100 font-black">
            {{ kanban.phases[props.phase_id].name }}
            <div class="bg-[#2c975b] pt-1.5 text-white rounded-full p-1 w-5 h-5 justify-center items-center flex text-sm">
                {{ kanban.phases[props.phase_id].tasks_count }}
            </div>
            <div v-if="kanban.phases[props.phase_id].completed_at !== null" class="text-xs bg-[#38516C] bg-opacity-50 px-2 py-1">Completion</div>
        </div>
        <div class="flex items-center gap-1">
            <PlusIcon
                @click="createTask()"
                class="h-6 w-6 text-white hover:cursor-pointer"
                aria-hidden="true" />
            <Menu as="div" class="h-5 w-6 relative inline-block text-left">
                <div>
                    <MenuButton>
                        <EllipsisVerticalIcon class="-mr-1 h-5 w-5 text-white" />
                    </MenuButton>
                </div>

                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="py-1">
                            <MenuItem v-slot="{ active }">
                                <div @click="markAsCompleted(props.phase_id)" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                    Mark as completed
                                </div>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <div @click="deletePhase(props.phase_id)" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                    Delete
                                </div>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
    </div>

    <div class="p-4">
        <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" />

        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 relative"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, Bars2Icon, EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
import {ChevronDownIcon} from "@heroicons/vue/20/solid/index.js";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";

const kanban = useKanbanStore()

const emit = defineEmits(["markPhaseAsCompleted", "deletePhase"])

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const markAsCompleted = function (phase) {
    emit('markPhaseAsCompleted', phase)
}

const deletePhase = function (phase) {
    emit("deletePhase", phase)
}

</script>
