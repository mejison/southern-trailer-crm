<template>
    <div class="messenger">
        <div class="row">
            <div class="col-md-4 dids">
                <div class="card card card-row card-secondary mb-0">
                    <div class="card-header">
                        <h3 class="card-title">
                            DIDs
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="card" @click="activeDiDs = index; getMessages();" :class="{'card-info card-outline': index == activeDiDs}" v-for="(did, index) in dids" :key="index">
                            <div class="card-header">
                                <h5 class="card-title">{{ did.id }}</h5>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-tool" @click.stop.prevent="onRemoveDiDs(did)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 card card-row card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Send from <small>{{ from }}</small>
                        </h3>
                    </div>
                    <div class="card-body pt-0 pl-0 pr-0">
                        <div class="row h-100">
                            <div class="col-12">
                                <div class="messages h-100 p-3" ref="messanger">
                                    <div class="message" v-for="(message, index) in messages" :key="index">
                                        {{ message.message }}

                                        <div class="attached" v-if="message.attached && message.attached.length">
                                            <a class="item" target="_blank" :href="`/storage/attached/${getNameAttach(attach)}`"  v-for="(attach, index) in message.attached" :key="index">
                                                <i class="fas fa-paperclip"></i>&nbsp;<span>{{ getNameAttach(attach) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-auto px-4">
                                <div class="row">
                                    <div class="col-10">
                                        <div class=" position-relative">
                                            <input
                                                type="text" 
                                                placeholder="Enter message here ..." 
                                                class="form-control"
                                                v-model="message"
                                                v-on:keyup.enter="onSubmit"
                                            /> 
                                            <span class="attach" @click.prevent="onClickAttach">
                                                <i class="fas fa-paperclip"></i>
                                            </span>
                                        </div>
                                        <div class="attached" v-if="attached && attached.length">
                                            <a class="item" :href="attach.base64" :download="attach.name" v-for="(attach, index) in attached" :key="index">
                                                <span>{{ attach.name }}</span>
                                                <i class="fas fa-trash text-danger" @click.stop.prevent="onRemoveAttach(index)"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn w-100 btn-primary" @click.prevent="onSubmit">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        mounted() {
            console.log('Component mounted.') 
        },

        data() {
            return {
                activeDiDs: 0,
                message: '',
                from: '4328472999',
                dids: [
                    {
                        id: '2816081946',
                    },
                    {
                        id: '36725',
                    },
                    {
                        id: '8168038601',
                    },
                    {
                        id: '8329785782',
                    },
                    {
                        id: '3254569429',
                    },
                ],
                messages: [
                    {
                        date: '',
                        message: 'hello #1',
                    },
                    {
                        date: '',
                        message: 'hello #2',
                    },
                    {
                        date: '',
                        message: 'hello #3',
                    }
                ],
                attached: [],
            }
        },

        mounted() {
            this.getMessages();
        },

        methods: {
            getMessages() {
                axios.get(`/api/message?did=${this.dids[this.activeDiDs].id}`).then(({ data: { data } }) => {
                    this.messages = data;

                    setTimeout(() => {
                        const messanger = this.$refs.messanger
                        messanger.scrollTop = messanger.scrollHeight + 100;
                    }, 0)
                });
            },
            onRemoveAttach(removeIndex) {
                this.attached = this.attached.filter((row, index) => {
                    if (index != removeIndex) {
                        return row;
                    }
                })
            },
            onRemoveDiDs(did) {
                if (confirm('Are you sure?')) {
                    console.log('delete', did)
                }
            },
            onSubmit() {
                if (this.message) {
                    const fd = new FormData;
                    fd.append('message', this.message);
                    fd.append('from', this.from);
                    fd.append('did', this.dids[this.activeDiDs].id);
                    this.attached.forEach(attach => {
                        fd.append('attached[]', attach.file);
                    });

                    axios.post(`/api/message`, fd).then((data) => {
                        this.getMessages();
                        this.message = '';
                        this.attached = [];
                    });
                }
            },
            getNameAttach(attach) {
                return attach.replace('public/attached/', '')
            },
            onAttach(event) {
                const target = event.target
                const [file] = target.files

                const fr = new FileReader
                fr.onloadend = () => {
                    this.attached = [
                        ...this.attached,
                        {
                            name: file.name,
                            size: file.size,
                            base64: fr.result,
                            file: file,
                        }
                    ]
                }
                fr.readAsDataURL(file)
            },
            onClickAttach() {
                const input = document.createElement('input');
                input.type = 'file'
                input.accept = "image/*"
                input.onchange = this.onAttach
                input.click();
                
            },
        },
    }
</script>


<style lang="scss">
    .dids {
    }

    .messenger {
        .attach {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            cursor: pointer;
        }

        .messages {
            display: flex;
            flex-direction: column;
            background-image: url("/bk.png  ");
            background-size: 20%;
            align-items: flex-start;
            background-color: #F8F9FC;
            overflow: auto;
            max-height: 290px;
            min-height: 290px;

            .message {
                margin-bottom: 20px;
                background: #fff;
                border-radius: 4px;
                padding: 10px 15px;
                display: inline-block;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
                position: relative;

                .attached {
                    position: absolute;
                    bottom: -18px;
                    left: 0;
                    font-size: 12px;
                }
            }
        }

        .attached {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 15px;

            .item {
                display: flex;
                align-items: center;

                span {
                    text-overflow: ellipsis;
                    overflow: hidden; 
                    width: 260px; 
                    height: 1.2em; 
                    white-space: nowrap;
                }

                i.fas {
                    margin-left: 5px;
                }
            }
        }
    }
</style>
