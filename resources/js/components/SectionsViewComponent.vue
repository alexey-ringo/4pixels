<template>    
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">                        
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <a :href="'/sections/create'" class="btn btn-primary float-right">Создать новый отдел</a>
                </nav>                    
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Фото</th>
                            <th>Отдел</th>
                            <th>Пользователи</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>                            
                        <tr v-for="section in sections" :key="section.id">
                            <td class="product-col"><img :src="'/storage/' + section.logo" class="img-fluid"></td>
                            <td>
                                <h5>{{ section.name }}</h5>
                                <p>{{ section.description }}</p>
                                </td>
                            <td>
                                <div v-for="user in section.users" :key="user.id">
                                    <p>{{ user.name }}</p>                                    
                                </div>                                
                            </td>
                            <td>
                                <a :href="'/sections/' + section.id + '/edit'" class="btn btn-secondary">Редактировать</a>                                        
                                <button class="btn btn-danger" @click.prevent = "deleteSection(section.id)">Удалить</button> 
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
                sections: [],
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
            this.getSections();
        },
        methods: {
            getSections() {
            let uri = '/api/sections';
            this.axios.get(uri)
                .then((response) => {
                    if(response.data.links) {
                        this.links = response.data.links;
                    }
                    if(response.data.meta) {
                        this.meta = response.data.meta;
                    }
                    if(response.data.data) {
               	        this.sections = response.data.data;
                    }
                    else if (response.data.message) {
                        this.message = response.data.message;
                        swal("Ошибка", this.message, "error");                   
                    }
                    else {
                        swal("Ошибка", "Нет ответа от сервера при первоначальном доступе к списку отделов", "error");                    
                    }        
                })
                .catch(error => {
                    if(error.response) {
                        if(error.response.data.message) {
                            swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                        }                    }                    
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
                	        this.sections = response.data.data;
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
                	        this.sections = response.data.data;
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
            deleteSection(id) {
                let uri = `/api/sections/${id}`;
                if (confirm("Вы действительно хотите удалить информацию об этом отделе?")) {
                    this.axios.delete(uri)
                        .then((response) => {
                            if(response.data.data) {
                                //this.sections.splice(this.sections.indexOf(id), 1);
                                this.sections = response.data.data;
                            }
                            else if (response.data.message) {
                                this.message = response.data.message;
                                swal("Ошибка", this.message, "error");
                            }
                            else {
                                swal("Ошибка", "Нет ответа от сервера при попытке удаления выбранного отдела", "error");
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