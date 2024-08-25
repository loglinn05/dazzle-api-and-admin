<template>
    <div
        class="bg-violet-100 w-screen h-screen flex justify-center items-center"
    >
        <div class="flex flex-col gap-y-10 justify-center items-center">
            <h1 class="sm:text-5xl text-4xl text-pink-700 font-header">
                Page not found.
            </h1>
            <Button label="Go Home" class="w-fit" @click="$router.push('/')" />
        </div>
    </div>
</template>
