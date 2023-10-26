<template>
  <div class="max-w-7xl flex-1 mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8">
    <div class="w-full mb-6 flex">
      <Teleport to="body">
        <generic-modal :show="kanban.creatingTask" @close="kanban.creatingTask = false" key="createTaskModal">
          <div>
            <div class="mt-3 sm:mt-2">
              <DialogTitle as="h3" class="mb-2 text-base font-semibold leading-6 text-gray-900">Create a new task
              </DialogTitle>

              <div class="mb-2">
                <InputLabel input-label="Task Title"/>
                <InputField inputType="text" v-model="kanban.creatingTaskProps.name"
                            custom-class="border-gray-300 border-b"/>
                <ErrorMessage v-if="hasError('name')" :error-msg="getError('name')"/>
              </div>

              <Listbox as="div" v-model="kanban.creatingTaskProps.user_id" class="mt-2">
                <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assigned to</ListboxLabel>
                <div class="relative">
                  <ListboxButton
                      class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6">
                                        <span class="flex items-center">
                                            <img
                                                :src="getAvatar(kanban.users[kanban.creatingTaskProps.user_id || kanban.self.id])"
                                                alt=""
                                                class="h-5 w-5 flex-shrink-0 rounded-full"
                                            />
                                            <span class="ml-3 block truncate">{{
                                                kanban.users[kanban.creatingTaskProps.user_id || kanban.self.id].name
                                              }}</span>
                                        </span>
                    <span
                        class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                        </span>
                  </ListboxButton>

                  <transition leave-active-class="transition ease-in duration-100"
                              leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <ListboxOptions
                        class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                      <ListboxOption as="template" v-for="person in kanban.users" :key="person.id"
                                     :value="person.id" v-slot="{ active, selected }">
                        <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                          <div class="flex items-center">
                            <img :src="getAvatar(person)" alt="{{ person.name }}"
                                 class="h-5 w-5 flex-shrink-0 rounded-full"/>
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">{{
                                person.name
                              }}</span>
                          </div>

                          <span v-if="selected"
                                :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                        <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                                                    </span>
                        </li>
                      </ListboxOption>
                    </ListboxOptions>
                  </transition>
                </div>
              </Listbox>
              <ErrorMessage v-if="hasError('user_id')" :error-msg="getError('user_id')"/>

              <div class="grid grid-cols-2 gap-2">
                <div class="mt-2">
                  <InputLabel input-label="Phase"/>
                  <CustomSelectOption :select-options="kanban.phases" v-model="kanban.creatingTaskProps.phase_id"/>
                  <ErrorMessage v-if="hasError('phase_id')" :error-msg="getError('phase_id')"/>
                </div>

                <div class="mt-2">
                  <InputLabel input-label="Priority"/>
                  <CustomSelectOption :select-options="kanban.priorities"
                                      v-model="kanban.creatingTaskProps.priority_id"/>
                  <ErrorMessage v-if="hasError('priority_id')" :error-msg="getError('priority_id')"/>
                </div>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Due Date"/>
                <InputField v-model="kanban.creatingTaskProps.due_date" input-type="date" value="asd"/>
                <ErrorMessage v-if="hasError('due_date')" :error-msg="getError('due_date')"/>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Task Description"/>
                <textarea v-model="kanban.creatingTaskProps.description" rows="4"
                          class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"></textarea>
                <ErrorMessage v-if="hasError('description')" :error-msg="getError('description')"/>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Attachment"/>
                <input class="block text-sm font-medium leading-6 text-gray-900"
                       accept=".jpg, .jpeg, .png, image/jpeg, image/png" type="file" @change="onFileChange"/>
                <ErrorMessage v-if="hasError('attachment_image')" :error-msg="getError('attachment_image')"/>
              </div>

            </div>

            <div class="mt-5 sm:mt-6">
              <CustomSuccessBtn @click="addCard" btn-title="Add the card!"/>
            </div>
          </div>
        </generic-modal>
      </Teleport>
    </div>

    <div id="kanban-container" class="flex-1 flex overflow-auto scrollbar-hide shadow-lg">
      <div class="text-gray-900">
        <div class="h-full flex overflow-x-auto overflow-y-auto space-x-4">
          <task-column @deletePhase="deletePhase" @markPhaseAsCompleted="markAsCompleted" v-for="col in kanban.phases"
                       :phase_id="col.id"></task-column>
        </div>
      </div>
    </div>

    <!-- Modal to edit the selected card -->
    <Teleport to="body">
      <generic-modal v-if="kanban.hasSelectedTask()" @close="kanban.unselectTask()">
        <div class="relative">
          <TrashIcon class="w-6 h-6 absolute top-0 right-7 hover:cursor-pointer text-red-600"
                     @click="deleteCard(kanban.selectedTask.id)"/>
          <PencilSquareIcon class="w-6 h-6 absolute top-0 right-0 hover:cursor-pointer text-blue-600"
                            @click="showEditCard"/>
          <!--          details task view -->
          <template v-if="!isShowEditCard">

            <DialogTitle as="h3" class="mb-2 text-base font-semibold leading-6 text-gray-900">
              Task Details
            </DialogTitle>
            <div class="mt-1 sm:mt-5">
              <div class="mt-2">
                <InputLabel input-label="Title"/>
                <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">{{
                    kanban.selectedTask.name
                  }}
                </DialogTitle>
              </div>

              <div class="mt-2" v-if="kanban.selectedTask.description">
                <InputLabel input-label="Description"/>
                <p>{{ kanban.selectedTask.description }}</p>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Phase"/>
                <p class="text-sm text-gray-500">
                  {{ kanban.phases[kanban.selectedTask.phase_id].name }}
                </p>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Assignee"/>
                <div class="text-sm text-gray-500 flex gap-2 items-center">
                  <img class="w-6 h-6 shadow-lg rounded-full border-2 border-blue-800"
                       :src="getAvatar(kanban.selectedTask.user)" :alt="kanban.selectedTask.user.name"/>
                  <p>{{ kanban.selectedTask.user.name }}</p>
                </div>
              </div>

              <div class="mt-2">
                <div v-if="kanban.selectedTask.completed_at" class="text-sm text-gray-500 mt-2">
                  <InputLabel input-label="Completed At"/>
                  <span class="bg-green-400 px-2 py-1 text-white rounded-md">{{
                      kanban.selectedTask.completed_at
                    }}</span>
                </div>
              </div>

              <div class="mt-3">
                <div v-if="kanban.selectedTask.due_date" class="text-sm text-gray-500 mt-2">
                  <InputLabel input-label="Due Date"/>
                  <span class="bg-red-400 px-2 py-1 text-white rounded-md">{{
                      kanban.selectedTask.due_date
                    }}</span>
                </div>
              </div>

              <div class="mt-3">
                <div v-if="kanban.selectedTask.priority" class="text-sm text-gray-500 mt-2">
                  <InputLabel input-label="Priority"/>
                  <span :style="{color: kanban.selectedTask.priority.color}" class="bg-[#00425B] px-2 py-1 rounded-md">{{
                      kanban.selectedTask.priority.name
                    }}</span>
                </div>
              </div>

              <div class="mt-3">
                <div v-if="kanban.selectedTask.attachment" class="text-sm text-gray-500 mt-2">
                  <InputLabel input-label="Attachment"/>
                  <img class="w-14 border-2 h-14 object-cover cursor-pointer py-1 rounded-md"
                       :src="kanban.selectedTask.attachment" alt="attachment-img"/>
                </div>
              </div>


            </div>

            <div class="mt-5 sm:mt-6">
              <button type="button"
                      class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                      @click="kanban.unselectTask()">Close
              </button>
            </div>
          </template>
          <!--          edit task view-->
          <template v-else>

            <DialogTitle as="h3" class="mb-6 text-base font-semibold leading-6 text-gray-900">Update task</DialogTitle>

            <div class="mb-2">
              <InputLabel input-label="Task Title"/>
              <InputField inputType="text" v-model="kanban.selectedTask.name"
                          custom-class="border-gray-300 border-b"/>
              <ErrorMessage v-if="hasError('name')" :error-msg="getError('name')"/>
            </div>

            <Listbox as="div" v-model="kanban.selectedTask.user_id" class="mb-2">
              <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assigned to</ListboxLabel>
              <div class="relative mt-2">
                <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6">
                  <span class="flex items-center">
                    <img
                        :src="getAvatar(kanban.users[kanban.selectedTask.user_id || kanban.self.id])"
                        alt=""
                        class="h-5 w-5 flex-shrink-0 rounded-full"
                    />
                    <span class="ml-3 block truncate">
                      {{ kanban.users[kanban.selectedTask.user_id || kanban.self.id].name }}
                    </span>
                  </span>
                  <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                  </span>
                </ListboxButton>

                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                  <ListboxOptions class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="person in kanban.users" :key="person.id" :value="person.id" v-slot="{ active, selected }">
                      <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                        <div class="flex items-center">
                          <img :src="getAvatar(person)" alt="{{ person.name }}" class="h-5 w-5 flex-shrink-0 rounded-full"/>
                          <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                            {{ person.name }}
                          </span>
                        </div>
                        <span v-if="selected" :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                          <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                        </span>
                      </li>
                    </ListboxOption>
                  </ListboxOptions>
                </transition>
              </div>
            </Listbox>
            <ErrorMessage v-if="hasError('user_id')" :error-msg="getError('user_id')"/>

            <div class="grid grid-cols-2 gap-2">
              <div class="mt-2">
                <InputLabel input-label="Phase"/>
                <CustomSelectOption :select-options="kanban.phases" v-model="kanban.selectedTask.phase_id"/>
                <ErrorMessage v-if="hasError('phase_id')" :error-msg="getError('phase_id')"/>
              </div>

              <div class="mt-2">
                <InputLabel input-label="Priority"/>
                <CustomSelectOption :select-options="kanban.priorities"
                                    v-model="kanban.selectedTask.priority_id"/>
                <ErrorMessage v-if="hasError('priority_id')" :error-msg="getError('priority_id')"/>
              </div>
            </div>

            <div class="mt-2">
              <InputLabel input-label="Due Date"/>
              <InputField v-model="kanban.selectedTask.due_date" input-type="date" value="asd"/>
              <ErrorMessage v-if="hasError('due_date')" :error-msg="getError('due_date')"/>
            </div>

            <div class="mt-2">
              <InputLabel input-label="Task Description"/>
              <textarea v-model="kanban.selectedTask.description" rows="4"
                        class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"></textarea>
              <ErrorMessage v-if="hasError('description')" :error-msg="getError('description')"/>
            </div>

            <div class="mt-2">
              <InputLabel input-label="Attachment"/>
              <input class="block text-sm font-medium leading-6 text-gray-900"
                     accept=".jpg, .jpeg, .png, image/jpeg, image/png" type="file" @change="onFileChange"/>
              <ErrorMessage v-if="hasError('attachment_image')" :error-msg="getError('attachment_image')"/>
            </div>

            <div class="flex gap-2 justify-end w-full">
              <div class="mt-5">
                <button type="button"
                        class="w-full justify-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500"
                        @click="closeEditPopup()">
                  Cancel
                </button>
              </div>
              <div class="mt-5">
                <button type="button"
                        class="w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                        @click="editCard()">
                  Update Card!
                </button>
              </div>
            </div>
          </template>
        </div>

      </generic-modal>
    </Teleport>

  </div>
</template>

<script setup>

import {ref, onMounted, onUnmounted, nextTick} from 'vue'
import {useKanbanStore} from '../stores/kanban'
import {DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from '@headlessui/vue'
import {CheckIcon, ChevronUpDownIcon, TrashIcon, PencilIcon, PencilSquareIcon} from '@heroicons/vue/20/solid'
import {sha256} from 'js-sha256';


const kanban = useKanbanStore()
const selected = ref(null)
const errors = ref(null)

const test = ref('');

let isShowEditCard = ref(false);

const getAvatar = function (user) {
  if (user.profile_picture_url !== null) {
    return user.profile_picture_url;
  } else {
    return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
  }
}

const file = ref(null);

const onFileChange = function (e) {
  file.value = e.target.files[0];
}

const getError = function (field) {
  if (errors.value && errors.value[field]) {
    return errors.value[field][0];
  }
  return null;
}

const hasError = function (field) {
  if (errors.value && errors.value[field]) {
    return true;
  }
  return false;
}

// Define these functions outside of onMounted so they're in the component's scope
let pos = {top: 0, left: 0, x: 0, y: 0};
let ele;

const mouseDownHandler = function (e) {
  ele.style.cursor = 'grabbing';
  ele.style.userSelect = 'none';

  pos = {
    left: ele.scrollLeft,
    top: ele.scrollTop,
    x: e.clientX,
    y: e.clientY,
  };

  document.addEventListener('mousemove', mouseMoveHandler);
  document.addEventListener('mouseup', mouseUpHandler);
};

const mouseMoveHandler = function (e) {
  const dx = e.clientX - pos.x;
  const dy = e.clientY - pos.y;

  ele.scrollTop = pos.top - dy;
  ele.scrollLeft = pos.left - dx;
};

const mouseUpHandler = function () {
  ele.style.cursor = 'grab';
  ele.style.removeProperty('user-select');

  document.removeEventListener('mousemove', mouseMoveHandler);
  document.removeEventListener('mouseup', mouseUpHandler);
};

const refreshTasks = async () => {
  try {
    const response = await axios.get('/api/tasks');
    const originalTasks = response.data;
    kanban.phases = originalTasks.reduce((acc, cur) => {
      acc[cur.id] = cur;
      return acc;
    }, {});
  } catch (error) {
    console.error('There was an error fetching the tasks!', error);
  }
}

const refreshPriorities = async () => {
  try {
    const response = await axios.get('/api/priorities');
    const originalPriorities = response.data.data;
    kanban.priorities = originalPriorities.reduce((acc, cur) => {
      acc[cur.id] = cur;
      return acc;
    }, {});

    kanban.creatingTaskProps.priority_id = originalPriorities[0].id
  } catch (error) {
    console.error('There was an error fetching the priorities!', error);
  }
}

const refreshUsers = async () => {
  try {
    const response = await axios.get('/api/users');
    const originalUsers = response.data;
    // rekey originalUsers to use the id property in the objects as the array key
    kanban.users = originalUsers.reduce((acc, cur) => {
      acc[cur.id] = cur;
      return acc;
    }, {});
  } catch (error) {
    console.error('There was an error fetching the users!', error);
  }
}

const getSelf = async () => {
  try {
    const response = await axios.get('/api/user');
    kanban.self = response.data;
    if (kanban.creatingTaskProps.user_id === null) {
      kanban.creatingTaskProps.user_id = kanban.self.id;
    }
    if (kanban.self.profile_picture_url === null) {
      kanban.self.profile_picture_url = getAvatar(kanban.self)
    }
  } catch (error) {
    console.error('There was an error fetching the logged in user!', error);
  }
}

const addCard = async () => {
  try {
    let formData = new FormData();
    formData.append('name', kanban.creatingTaskProps.name);
    formData.append('description', kanban.creatingTaskProps.description);
    formData.append('due_date', kanban.creatingTaskProps.due_date);
    formData.append('phase_id', kanban.creatingTaskProps.phase_id);
    formData.append('user_id', kanban.creatingTaskProps.user_id);
    formData.append('priority_id', kanban.creatingTaskProps.priority_id);
    formData.append('attachment_image', file.value);
    const response = await axios.post('/api/tasks', formData, {
      'Content-Type': 'multipart/form-data',
    });
    kanban.creatingTask = false;
    kanban.creatingTaskProps = {
      name: null,
      phase_id: null,
      user_id: null
    };
    await refreshTasks();
    errors.value = null;
  } catch (error) {
    if (error.response.status === 422) {
      errors.value = error.response.data.errors;
    }
  }
}

const deleteCard = async (id) => {
  try {
    const response = await axios.delete('/api/tasks/' + id);
    await refreshTasks();
    kanban.unselectTask();
  } catch (error) {
    console.error('There was an error deleting the task!', error);
  }
}

const getSelectedTask = async () => {
  try {
    const response = await axios.get('/api/tasks/' + kanban.selectedTask.id);
    kanban.selectTask(response.data.data);
  } catch (error) {
    console.error('There was an error deleting the task!', error);
  }
}
const showEditCard = () => {
  isShowEditCard.value = true;
}

const closeEditPopup = () => {
  isShowEditCard.value = false;
  getSelectedTask();
  refreshTasks();
}

const editCard = async () => {
  try {
    let formData = new FormData();
    formData.append('name', kanban.selectedTask.name);
    formData.append('description', kanban.selectedTask.description);
    formData.append('due_date', kanban.selectedTask.due_date);
    formData.append('phase_id', kanban.selectedTask.phase_id);
    formData.append('user_id', kanban.selectedTask.user_id);
    formData.append('priority_id', kanban.selectedTask.priority_id);
    formData.append('attachment_image', file.value);

    const response = await axios.post('/api/tasks/' + kanban.selectedTask.id + '?_method=put', formData, {
      'Content-Type': 'multipart/form-data',
    });
    await refreshTasks();
    kanban.unselectTask();
    isShowEditCard.value = false;
  } catch (error) {
    if (error.response.status === 422) {
      errors.value = error.response.data.errors
    } else {
      isShowEditCard.value = false;
    }
    console.error('There was an error deleting the task!', error);
  }
}

const markAsCompleted = async (phaseId) => {
  try {
    const response = await axios.patch('/api/phases/' + phaseId, {});
    await refreshTasks();
    kanban.unselectTask();
  } catch (error) {
    console.error('There was an error deleting the task!', error);
  }
}

const deletePhase = async (phaseId) => {
  try {
    const response = await axios.delete('/api/phases/' + phaseId, {});
    await refreshTasks();
    kanban.unselectTask();
  } catch (error) {
    console.error('There was an error deleting the task!', error);
  }
}

onMounted(async () => {
  await refreshPriorities();
  await refreshTasks();
  await refreshUsers();
  await getSelf();

  await nextTick();

  ele = document.getElementById('kanban-container');
  if (ele) {
    ele.style.cursor = 'grab';
    ele.addEventListener('mousedown', mouseDownHandler);
  }

})

onUnmounted(() => {
  if (ele) {
    // Clean up the event listener when the component is unmounted.
    ele.removeEventListener('mousedown', mouseDownHandler);
  }
})
</script>

<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
  -ms-overflow-style: none;
  /* IE and Edge */
  scrollbar-width: none;
  /* Firefox */
}</style>
