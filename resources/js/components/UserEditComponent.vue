<template>    
    <div class="col-md-12">                
        <div class="card">
            <div class="card-header">
                <h3>Изменение данных пользователя</h3>
            </div>
            <form @submit.prevent="updateUser(user.id)">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="name">Имя пользователя</label>
                                <input name="name"
                                       id="name"                                           
                                       type="text"
                                       class="form-control"
                                       v-model="user.name"
                                >
                                </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email"
                                       id="email"                                            
                                       type="text"
                                       class="form-control"
                                       v-model="user.email"
                                >                                                                     
                            </div>

                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input name="password"
                                       id="password"                                            
                                       type="text"
                                       class="form-control"
                                       v-model="user.password"
                                >                                                                     
                            </div>                                    
                        </div>
                    </div>                        
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Применить</button>
                    <a ref="goUsersPage" :href="'/users/'" class="btn btn-secondary float-right">Отмена</a>
                </div>
            </form>    
        </div>
    </div>       
</template>

<script>
export default {
    props: [
        'userId'
        ],
    data: function () {
        return {
            user: {},
            message: ''
        }
    },
    mounted() {           
        this.getUser(this.userId);        
    },
    methods: {
        getUser(id) {
            let uri = `/api/users/${id}/edit`;
            this.axios.get(uri).then((response) => {
                if(response.data.data) {
                this.user = response.data.data;                
                }
                else if (response.data.message) {
                    this.message = response.data.message;
                    swal("Ошибка", this.message, "error");
                    this.triggerGoUsersPage();
                }
                else {
                    swal("Ошибка", "Нет ответа от сервера при первоначальном доступе к модифицируему пользователю", "error");
                    this.triggerGoUsersPage();
                }
            })
            .catch(error => {
                if(error.response.data.message) {             
                    swal('Ошибка - ' + error.response.status, error.response.data.message, "error");
                    this.triggerGoUsersPage();             
                }          
                else {
                    swal('Ошибка', "Внутренняя ошибка сервера", "error");                
                    this.triggerGoUsersPage();
                }
            });
        },
        updateUser(id) {
            let uri = `/api/users/${id}`;
            this.axios.patch(uri, this.user/*{}*/)
                .then((response) => {
                    if(response.data.message) {
                        this.message = response.data.message;
                        swal("Сохранение изменений", this.message, "success");
                        this.triggerGoUsersPage();            
                    }
                    else {
                        swal("Ошибка", "Нет ответа от сервера при сохранении изменений данных пользователя", "error");
                        this.triggerGoUsersPage();
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
                        this.triggerGoUsersPage();
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
        triggerGoUsersPage() {
            this.$refs.goUsersPage.click();
        }        
    }
}
</script>