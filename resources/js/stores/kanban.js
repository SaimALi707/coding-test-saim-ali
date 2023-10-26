import {defineStore} from 'pinia'

export const useKanbanStore = defineStore('kanban', {
    state: () => {
        return {
            hoveredName: 'nothing',
            selectedTask: null,
            phases: [],
            users: [],
            priorities: [],
            creatingTask: false,
            creatingTaskProps: {
                name: '',
                description: '',
                phase_id: null,
                user_id: null,
                priority_id: null,
                due_date: '',
                attachment: null
            },
            self: null,
        }
    },
    actions: {
        unhoverTask() {
            this.hoveredName = 'nothing'
        },
        selectTask(task) {
            console.log("task into selecte: ", task)
            this.selectedTask = task
        },
        unselectTask(task) {
            this.selectedTask = null
        },
        hasSelectedTask() {
            return this.selectedTask !== null
        },
    },
})
