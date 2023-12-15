<template>
    <Head title="Books" />
    <div class="flex flex-col mx-20">
        <div class="overflow-x-auto">
            <div class="p-1.5 w-full inline-block align-middle">
                <div class="flex flex-row my-10">
                    <div class="grow font-bold text-3xl">
                        <h1>BOOKS</h1>
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-blue-500 hover:bg-blue-600 rounded-md">
                            <button @click="openCreateModal" class="p-2 w-30 text-center text-white">
                                Add Book
                            </button>
                        </div>
                        <div class="bg-red-500 hover:bg-red-600 rounded-md">
                            <button @click="confirmDeleteAllData" class="p-2 w-30 text-center text-white">
                                Delete All Data
                            </button>
                        </div>
                    </div>
                </div>
                <Modal :show="showCreateModal" @close="closeCreateModal">
                    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md">
                        <h1 class="text-2xl font-bold mb-4">Add Book</h1>
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-600">Title</label>
                                <input v-model="form.title" type="text" id="title" name="title"
                                    class="mt-1 p-2 border w-full" />
                                <div class="text-red-500 text-xs" v-if="errors.title">{{ errors.title }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="writer" class="block text-sm font-medium text-gray-600">Writer</label>
                                <input v-model="form.writer" type="text" id="writer" name="writer"
                                    class="mt-1 p-2 border w-full" />
                                <div class="text-red-500 text-xs" v-if="errors.writer">{{ errors.writer }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="publisher" class="block text-sm font-medium text-gray-600">Publisher</label>
                                <input v-model="form.publisher" type="text" id="publisher" name="publisher"
                                    class="mt-1 p-2 border w-full" />
                                <div class="text-red-500 text-xs" v-if="errors.publisher">{{ errors.publisher }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="year" class="block text-sm font-medium text-gray-600">Year</label>
                                <input v-model="form.year" type="number" id="year" name="year"
                                    class="mt-1 p-2 border w-full" />
                                <div class="text-red-500 text-xs" v-if="errors.year">{{ errors.year }}</div>
                            </div>
                            <div class="mt-6 flex space-x-4">
                                <PrimaryButton @click="submitForm">Submit</PrimaryButton>
                                <SecondaryButton @click="closeCreateModal">Cancel</SecondaryButton>
                            </div>
                        </form>
                    </div>
                </Modal>
                <Modal :show="confirmDeleteAllDataModal" @close="closeDeleteAllDataModal">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete all data?</h2>
                        <div class="mt-6 flex space-x-4">
                            <DangerButton @click="deleteAllData">Delete All</DangerButton>
                            <SecondaryButton @click="closeDeleteAllDataModal">Cancel</SecondaryButton>
                        </div>
                    </div>
                </Modal>
                <div v-if="$page.props.flash.message" class="my-4">
                    <span id="flashMessage" class="bg-green-500 p-2 rounded rounded-lg text-white">{{
                        $page.props.flash.message }}</span>
                </div>
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">NO
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">Writer
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                    Publisher</th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">Year
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs flex justify-center font-bold text-right text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="data.data && data.data.length > 0" class="divide-y divide-gray-200">
                            <tr v-for="(item, index) in data.data" :key="item.id">
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">{{
                                    (data.current_page - 1) * data.per_page + index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ item.title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ item.writer }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ item.publisher }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ item.year }}</td>
                                <td class="px-6 py-4 flex gap-4 text-sm font-medium justify-center whitespace-nowrap">
                                    <button @click.prevent="openEditModal(item)"
                                        class="text-green-500 hover:text-green-700">
                                        <svg class="h-6 w-6 text-blue-500" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                            <line x1="16" y1="5" x2="19" y2="8" />
                                        </svg>
                                    </button>
                                    <Modal :show="showEditModal" @close="closeEditModal">
                                        <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md">
                                            <h1 class="text-2xl font-bold mb-4">Edit Book</h1>
                                            <form @submit.prevent="submitFormEdit(form_edit.id)">
                                                <div class="mb-4">
                                                    <label for="title"
                                                        class="block text-sm font-medium text-gray-600">Title</label>
                                                    <input v-model="form_edit.title" type="text" id="title" name="title"
                                                        class="mt-1 p-2 border w-full" />
                                                    <div class="text-red-500 text-xs" v-if="errors.title">{{ errors.title }}
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="writer"
                                                        class="block text-sm font-medium text-gray-600">Writer</label>
                                                    <input v-model="form_edit.writer" type="text" id="writer" name="writer"
                                                        class="mt-1 p-2 border w-full" />
                                                    <div class="text-red-500 text-xs" v-if="errors.writer">{{ errors.writer
                                                    }}</div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="publisher"
                                                        class="block text-sm font-medium text-gray-600">Publisher</label>
                                                    <input v-model="form_edit.publisher" type="text" id="publisher"
                                                        name="publisher" class="mt-1 p-2 border w-full" />
                                                    <div class="text-red-500 text-xs" v-if="errors.publisher">{{
                                                        errors.publisher }}</div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="year"
                                                        class="block text-sm font-medium text-gray-600">Year</label>
                                                    <input v-model="form_edit.year" type="number" id="year" name="year"
                                                        class="mt-1 p-2 border w-full" />
                                                    <div class="text-red-500 text-xs" v-if="errors.year">{{ errors.year }}
                                                    </div>
                                                </div>
                                                <div class="mt-6 flex space-x-4">
                                                    <PrimaryButton @click="submitFormEdit">Submit</PrimaryButton>
                                                    <SecondaryButton @click="closeEditModal">Cancel</SecondaryButton>
                                                </div>
                                            </form>
                                        </div>

                                    </Modal>

                                    <button @click="confirmDeleteUser(item.id)" class="text-red-500 hover:text-red-700">
                                        <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                    </button>
                                    <Modal :show="showConfirmDeleteUserModal" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete this?
                                            </h2>
                                            <div class="mt-6 flex space-x-4">
                                                <DangerButton @click="deleteUser(item.id)">Delete</DangerButton>
                                                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="data.data && data.data.length == 0" class="text-gray-500 text-center mt-4">Tidak ada data
                    </div>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    v-if="data.per_page > 0" aria-label="Tabel navigation">
                    <span class="text-sm font-normal text-gray-500">
                        Showing
                        <span class="font-semibold text-gray-900">{{ (data.current_page - 1) * data.per_page + 1 }}-
                            {{ Math.min(data.current_page * data.per_page, data.total) }}</span>
                        of
                        <span class="font-semibold text-gray-900">{{ data.total }}</span>
                    </span>
                    <ul class="inline-flex item-stretch -space-x-px">
                        <li v-for="(item, index) in data.links" :key="index">
                            <a href="#" @click="pageTo(item.url)"
                                :class="{ 'bg-blue-500 text-white hover:text-white hover:cursor-text hover:bg-blue-500 rounded rounded-lg': item.active }"
                                class="flex item-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white rounded rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
                                v-html="item.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    data: Object,
    errors: Object,
});

// CREATE
const form = useForm({
    title: null,
    writer: null,
    publisher: null,
    year: null,
})
const showCreateModal = ref(false);
function openCreateModal() {
    showCreateModal.value = true;
}
function closeCreateModal() {
    showCreateModal.value = false;
}
function submitForm() {
    router.post('/store', form);
    showCreateModal.value = false;
}
// END OF CREATE

// EDIT
const form_edit = useForm({
    id: props.data.id,
    title: props.data.title,
    writer: props.data.writer,
    publisher: props.data.publisher,
    year: props.data.year,
});
const showEditModal = ref(false);
const idBook = ref('')
function openEditModal(item) {
    form_edit.id = item.id
    form_edit.title = item.title
    form_edit.writer = item.writer
    form_edit.publisher = item.publisher
    form_edit.year = item.year
    idBook.value = item.id

    showEditModal.value = true;
}
function closeEditModal() {
    showEditModal.value = false;
    form_edit.reset()
}
function submitFormEdit() {
    router.put('/update/' + idBook.value, form_edit)
    showEditModal.value = false;
}
// END OF EDIT

// DELETE
const deleteItem = ref(null)
const showConfirmDeleteUserModal = ref(false)
const confirmDeleteUser = (id) => {
    deleteItem.value = id;
    showConfirmDeleteUserModal.value = true;
}
const closeModal = () => {
    showConfirmDeleteUserModal.value = false
}
const deleteUser = () => {
    router.delete('/' + deleteItem.value, {
        onSuccess: () => closeModal()
    })
}
// END OF DELETE

// DELETE ALL DATA
const confirmDeleteAllDataModal = ref(false);
function confirmDeleteAllData() {
    confirmDeleteAllDataModal.value = true;
}
function closeDeleteAllDataModal() {
    confirmDeleteAllDataModal.value = false;
}
function deleteAllData() {
    router.delete('/');
    closeDeleteAllDataModal();
}
// END OF DELETE ALL DATA

// PAGINATION
const pageTo = (url) => {
    router.get(url)
}
// END OF PAGINATION

setTimeout(function () {
    var flashMessage = document.getElementById('flashMessage');
    if (flashMessage) {
        flashMessage.style.display = 'none';
    }
}, 5000);

</script>