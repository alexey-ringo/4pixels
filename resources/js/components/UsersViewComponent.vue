<template>
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">                        
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <a :href="'/users/create'" class="btn btn-primary float-right">Создать нового пользователя</a>
                </nav>                    
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Имя пользователя</th>
                            <th>Email</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>                            
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <a :href="'/users/' + user.id + '/edit'" class="btn btn-secondary">Редактировать</a>                                        
                                <button class="btn btn-danger" @click.prevent = "deleteUser(user.id)">Удалить</button> 
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row justify-content-center">
                    <nav aria-label="...">
                        <ul class="pagination">                       
                            <li class="page-item" v-if="paginateVisiblePrev">
                                <button class="page-link" @click="getPrevPage">Пред</button>                                
                            </li>
                            <li class="page-item" v-if="paginateVisiblePrev"><button class="page-link" @click="getPrevPage">1</button></li>
                            <li class="page-item active">
                                <button class="page-link">{{ meta.current_page }} <span class="sr-only">(current)</span></button>
                            </li>
                            <li class="page-item" v-if="paginateVisibleNext"><button class="page-link" @click="getNextPage">3</button></li>
                            <li class="page-item" v-if="paginateVisibleNext">
                                <button class="page-link" @click="getNextPage">След</button>                                
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>        
</template>

<script>
    export default {
        data: function () {
            return {
                users: [],
                message: '',
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null
                },
                meta: {
                    current_page: null,
                    from: null,
                    last_page: null,
                    path: null,
                    per_page: null,
                    to: null,
                    total: null
                }
            }
        },
        mounted() {            
            this.getUsers();
        },
        methods: {
            getUsers() {
            let uri = '/api/users';
            this.axios.get(uri)
                .then((response) => {
                    if(response.data.links) {
                        this.links = response.data.links;
                    }
                    if(response.data.meta) {
                        this.meta = response.data.meta;
                    }
                    if(response.data.data) {
               	        this.users = response.data.data;
                    }
                    else if (response.data.message) {
                        this.message = response.data.message;
                        swal("Ошибка", this.message, "error");                   
                    }
                    else {
                        swal("Ошибка", "Нет ответа от сервера при первоначальном доступе к списку маршрутов процессов задач", "error");                    
                    }        
                })
                .catch(error => {
                    if(error.response) {
                        if(error.response.data.message) {
                            swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                        }
                    }                    
                    else {
                        swal('Ошибка', "Внутренняя ошибка сервера", "error");                       
                    }
                });
            },
            getNextPage() {
                let uri = this.links.next;
                console.log(uri);
                this.axios.get(uri)
            	    .then((response) => {
            	        if(response.data.links) {
            	            this.links = response.data.links;
            	        }
            	        if(response.data.meta) {
            	            this.meta = response.data.meta;
            	        }
            	        if(response.data.data) {
                	        this.users = response.data.data;
            	        }
            	        else if (response.data.message) {
                            this.message = response.data.message;
                            swal("Ошибка", this.message, "error");                            
                        }
                        else {
                            swal("Ошибка", "Нет ответа от сервера", "error");                            
                        }        
                    })
                    .catch(error => {
                        if(error.response) {
                            if(error.response.data.message) {
                                swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                            }
                        }                    
                        else {
                            swal('Ошибка', "Внутренняя ошибка сервера", "error");                       
                        }
                    });
            },
            getPrevPage() {
                let uri = this.links.prev;
                this.axios.get(uri)
            	    .then((response) => {
            	        if(response.data.links) {
            	            this.links = response.data.links;
            	        }
            	        if(response.data.meta) {
            	            this.meta = response.data.meta;
            	        }
            	        if(response.data.data) {
                	        this.users = response.data.data;
            	        }
            	        else if (response.data.message) {
                            this.message = response.data.message;
                            swal("Ошибка", this.message, "error");                            
                        }
                        else {
                            swal("Ошибка", "Нет ответа от сервера", "error");
                            this.$router.push({name: 'contacts'});
                        }        
                    })
                    .catch(error => {
                        if(error.response) {
                            if(error.response.data.message) {
                                swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                            }
                        }                    
                        else {
                            swal('Ошибка', "Внутренняя ошибка сервера", "error");                       
                        }
                    });
                
            },
            deleteUser(id) {
                let uri = `/api/users/${id}`;
                if (confirm("Вы действительно хотите удалить этого пользователя?")) {
                    this.axios.delete(uri)
                        .then((response) => {
                            if(response.data.data) {
                                //this.users.splice(this.users.indexOf(id), 1);
                                this.users = response.data.data;
                            }
                            else if (response.data.message) {
                                this.message = response.data.message;
                                swal("Ошибка", this.message, "error");
                            }
                            else {
                                swal("Ошибка", "Нет ответа от сервера при попытке удаления выбранного пользователя", "error");
                            }        
                        })
                        .catch(error => {
                            if(error.response) {
                                if(error.response.data.message) {
                                    swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                                }        
                            }                    
                            else {
                                swal('Ошибка', "Внутренняя ошибка сервера", "error");                       
                            }
                        });
                }

            }
        },
        computed: {
            paginateVisibleNext() {
                console.log(this.meta.current_page);
                console.log(this.meta.last_page);
                if(this.meta.current_page === this.meta.last_page) {
                    return false;
                }
                else {
                    return true;
                }
                
            },
            paginateVisiblePrev() {
                if(this.meta.current_page === this.meta.from) {
                    return false;
                }
                else {
                    return true;
                }
            },
            nextPageNum() {

            },
            prevPageNum() {

            }
        },
    }
</script>