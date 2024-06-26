require('./bootstrap');
import {createApp} from 'vue';
import print from 'vue3-print-nb'


import Example from './components/Example.vue'
import Account from './components/admin/Account.vue'
import AccountEdit from './components/admin/AccountEdit.vue'
import ChatAdmin from './components/admin/Chat.vue'
import Reports from './components/admin/Reports.vue'

import Branch from './components/admin/Branch.vue'
import BranchEdit from './components/admin/BranchEdit.vue'
// owner
import AccountOwner from './components/owner/Account.vue'
import AccountEditOwner from './components/owner/AccountEdit.vue'
import PostOwner from './components/owner/Post.vue'
import PostEditOwner from './components/owner/PostEdit.vue'
import ChatOwner from './components/owner/Chat.vue'

// frontend
import FrontbranchMap from './components/pages/Map.vue'
import FrontReservation from './components/pages/Reservation.vue'
import Chat from './components/pages/Chat.vue'
import Services from './components/pages/Services.vue'
import AdminChat from './components/pages/AdminChat.vue'

const app = createApp({})
app.component('Example', Example);
app.component('Account', Account);
app.component('Branch', Branch);
app.component('branch_edit', BranchEdit);
app.component('account_edit', AccountEdit);
app.component('map_branch', FrontbranchMap);
app.component('frontend_reservation', FrontReservation);
app.component('Chat', Chat);
app.component('Services', Services);
app.component('admin_chat', AdminChat);
app.component('chat_admin', ChatAdmin);
app.component('Reports', Reports);

// owner
app.component('account_owner', AccountOwner);
app.component('account_edit_owner', AccountEditOwner);
app.component('post_owner', PostOwner);
app.component('post_edit_owner', PostEditOwner);
app.component('chat_owner', ChatOwner);


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css'

app.use(print)
app.use(VueSweetalert2)
app.mount('#app');
