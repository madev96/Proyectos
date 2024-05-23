<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';



//recibir parámetros para tabla lista clientes
const page = usePage()
const contacts = ref(page.props.contacts)

const onDeleteSuccess = (e) => {
    console.log(e)
    contacts.value = e.props.contacts;
}

</script>

<template>
    <Head title="Contactos"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contactos</h2>
                <Link :href="route('contact.create')">
                    Crear contacto
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <!--código para la tabla-->
                    <div className="relative overflow-x-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Telefono
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Visibilidad
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Avatar
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contact in contacts" className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{contact.name}}
                                    </th>
                                    <td className="px-6 py-4">
                                        {{contact.phone}}

                                    </td>
                                    <td className="px-6 py-4">
                                        {{contact.privacity}}

                                    </td>
                                    <td className="px-6 py-4">
                                        <img class="h-16" :src="`/storage/${contact.avatar}`"/>
                                    </td>
                                    <td className="px-6 py-4">
                                        <div>
                                            <Link :href="route('contact.edit', contact)">
                                                Editar
                                            </Link>
                                            -
                                            <Link @success="onDeleteSuccess" :href="route('contact.destroy', contact)" method="delete" as="button">
                                                Eliminar
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
