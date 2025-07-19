<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem} from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a ticket',
        href: '/dashboard',
    },
];

const page = usePage()
const form = useForm({
    subject: '',
    category_id: '',
    message: '',
});

const submit = () => {
    form.post(route('ticket.store'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <Head title="Create a ticket" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex gap-2">
                <div class="flex flex-col space-y-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <Label for="name">Subject</Label>
                            <Input id="name" class="mt-1 block w-full" v-model="form.subject" required placeholder="Subject" />
                            <InputError class="mt-2" :message="form.errors.subject" />
                        </div>

                        <div>
                            <Label for="message">Category</Label>
                            <select
                                :class="
                                    cn(
                                        'flex h-9 w-full min-w-0 rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary selection:text-primary-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30',
                                        'focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50',
                                        'aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40',
                                    )
                                "
                                id="category-select"
                                class="mt-1 block w-full"
                                v-model="form.category_id"
                                required
                            >
                                <option value="">Choose category</option>
                                <option v-for="category in page.props.categories"
                                        :key="category.id"
                                        :value="category.id"
                                >{{category.name}}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id" />
                        </div>

                        <div>
                            <Label for="message">Message</Label>
                            <textarea
                                :class="
                                    cn(
                                        'flex h-9 w-full min-w-0 rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary selection:text-primary-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30',
                                        'focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50',
                                        'aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40',
                                    )
                                "
                                id="message"
                                class="mt-1 block w-full"
                                v-model="form.message"
                                required
                                placeholder="Message"
                            />
                            <InputError class="mt-2" :message="form.errors.message" />
                        </div>

                        <div class="flex items-center gap-4">
                            <Button :disabled="form.processing">Save</Button>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
