<template>    
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">
                <h3>Создание нового отдела</h3>
            </div>
            <form @submit.prevent="storeSection(section.id)">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="name">Название отдела</label>
                                <input name="name"
                                       id="name"                                           
                                       type="text"
                                       class="form-control"
                                       v-model="section.name"
                                >
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea name="description"
                                          id="description"                                            
                                          type="text"
                                          class="form-control"
                                          rows="3"
                                          v-model="section.description"
                                >
                                </textarea>                                                                     
                            </div>

                            <div class="form-group">
                                <label for="logo">Фото</label>
                                <input name="logo"                                                                                 
                                       type="file"
                                       id="file"                                       
                                       accept="image/*"
                                       class="form-control"
                                       @change="onFileChange"                                       
                                >
                            </div>            
                            
                            <img :src="'/storage/' + imageSrc" class="img-thumbnail" v-if="image">

                            <div class="form-group">
                                <h5>Пользователи</h5>
                                <div class="form-check" v-for="user in users" :key="user.id">
                                    <input name="usersCheckBox"
                                           type="checkbox" 
                                           class="form-check-input"
                                           v-bind:value="user.id"
                                           v-model="usersChecked"
                                    >
                                    <label class="form-check-label" for="rolesCheckBox">{{ user.name }}</label>
                                </div>
                            </div>  
                                     
                        </div>
                    </div>                        
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Применить</button>
                    <a ref="goSectionsPage" :href="'/sections/'" class="btn btn-secondary float-right">Отмена</a>
                </div>
            </form>    
        </div>
    </div>        
</template>

<script>
export default {    
    data: function () {
        return {
            section: {},
            message: '',
            usersChecked: [],
            users: [],
            image: null,
            imageSrc: '',            
        }
    },
    mounted() {           
        this.getUsers();        
    },
    methods: {
        getUsers() {
            let uri = '/api/users?alldata=1';            
            this.axios.get(uri)                
                .then((response) => {                    
                    if(response.data.data) {
                        this.users = response.data.data;                          
                    }
                    else if (response.data.message) {
                        this.message = response.data.message;
                        swal("Ошибка", this.message, "error");                   
                    }
                    else {
                        swal("Ошибка", "Нет ответа от сервера при первоначальном доступе к списку пользователей", "error");                    
                    }        
                })
                .catch(error => {
                    if(error.response) {
                        if(error.response.data.message) {
                            swal('Ошибка - ' + error.response.status, error.response.data.message, "error");                                                     
                        }                    }                    
                        else {
                            swal('Ошибка', "Внутренняя ошибка сервера", "error");
                            this.triggerGoSectionsPage();                       
                        }
                });
        },
        storeSection() {
            this.section.users = this.usersChecked;            
            this.section.logo = this.imageSrc;
            let uri = `/api/sections`;
            this.axios.post(uri, this.section/*{}*/)
                .then((response) => {
                    if(response.data.message) {
                        this.message = response.data.message;
                        swal("Сохранение изменений", this.message, "success");
                        this.triggerGoSectionsPage();            
                    }
                    else {
                        swal("Ошибка", "Нет ответа от сервера при сохранении изменений данных отдела", "error");
                        this.triggerGoSectionsPage();
                    }
                })
                .catch(error => {
                    if(error.response) {
                        if(error.response.data.message) {               
                           swal('Ошибка - ' + error.response.status, error.response.data.message, "error");
                            this.$router.push({name: 'users'});                
                        }//Ошибки валидации
                        else {
                            swal('Ошибка - ' + error.response.status, this.errMessageToStr(error.response.data), "error");
                        }
                    }            
                    else {
                        swal('Ошибка', "Внутренняя ошибка сервера", "error");              
                        this.triggerGoSectionsPage();
                    }
                });
        },        
        errMessageToStr(errors) {
            let result = '';
            for(let key in errors) {
                errors[key].forEach(function(item){
                result += item + '; ';
                });
            }
        return result;
        },
        triggerGoSectionsPage() {
            this.$refs.goSectionsPage.click();
        },        
        onFileChange(event) {
            this.image = event.target.files[0];
            let formData = new FormData();
            formData.append('logo', this.image);
            
            let uri = `/api/upload`;
            this.axios.post(uri,
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            )
            .then((response) => {                    
                if(response.data.data) {
                    this.imageSrc = response.data.data;                          
                }
                else if (response.data.message) {
                    this.message = response.data.message;
                    swal("Ошибка", this.message, "error");                   
                }
                else {
                    swal("Ошибка", "Нет ответа от сервера при загрузке изображения", "error");                    
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
                    this.triggerGoSectionsPage();                       
                }
            });
        }       
    }
}
</script>