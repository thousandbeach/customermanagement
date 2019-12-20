<template>
    <div>
        <form action="">
            <div class="relative pb-4">
                <label for="name" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">お名前</label>
                <input id="name" type="text" class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"
                       placeholder="山田ルイ16世">
            </div>
            <div class="flex justify-end">
                <button class="py-2 px-4 text-blue-500 border border-blue-500 mr-5 hover:bg-gray-100 hover:border-blue-300">キャンセル</button>
                <button class="bg-blue-500 py-2 px-4 text-white hover:bg-blue-400">新規登録</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "ContactsCreate"
    }
</script>

<style scoped>

</style>
