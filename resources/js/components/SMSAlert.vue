<template>
    <div class="sms-alert">
        <form action="">
            <div class="d-flex flex-column">
                <div class="mb-2">
                    <input name="from"  v-model="data.from" readonly />
                </div>
                <div class="mb-2">
                    <input name="to"  v-model="data.to" readonly />
                </div>
                <div class="mb-2">
                    <input type="message" v-model="data.message">
                </div>
            </div>
            <button class="btn btn-primary" @click.prevent="onClickNotify">Notify</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    from: '4328472999',
                    to: '3254569429',
                    message: '# to prepare that trailer',
                }
            }
        },
        methods: {
            onClickNotify() {
                
                axios.get(`/api/sms-alert?from=${this.data.from}&to=${this.data.to}&message=${encodeURIComponent(this.data.message)}`)
            },
        },
    }
</script>