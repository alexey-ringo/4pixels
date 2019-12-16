import VueRouter from 'vue-router';

//import Users from './components/UsersViewComponent';
import UserCreate from './components/UserCreateComponent';
import UserEdit from './components/UserEditComponent';

//import Sections from './components/SectionsViewComponent';
import SectionCreate from './components/SectionCreateComponent';
import SectionEdit from './components/SectionEditComponent';

export default new VueRouter({

    routes : [
        
        //{ path: 'users',  name: 'users', component: Users },        
        { path: 'create',  name: 'user-create', component: UserCreate },
        { path: 'users/:id',  name: 'user-edit', component: UserEdit },
            
        //{ path: 'sections',  name: 'sections', component: Sections },        
        { path: 'sections/create',  name: 'section-create', component: SectionCreate },
        { path: 'sections/:id',  name: 'section-edit', component: SectionEdit }        
    ],    
    mode: 'history'    
});