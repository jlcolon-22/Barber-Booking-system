require('./bootstrap');
import {createApp} from 'vue';

import Example from './components/Example.vue'
import Account from './components/admin/Account.vue'
import AccountEdit from './components/admin/AccountEdit.vue'

import Branch from './components/admin/Branch.vue'
import BranchEdit from './components/admin/BranchEdit.vue'
// owner
import AccountOwner from './components/owner/Account.vue'
import AccountEditOwner from './components/owner/AccountEdit.vue'
import PostOwner from './components/owner/Post.vue'
import PostEditOwner from './components/owner/PostEdit.vue'

// frontend
import FrontbranchMap from './components/pages/Map.vue'
import FrontReservation from './components/pages/Reservation.vue'
const app = createApp({})
app.component('Example',Example);
app.component('Account',Account);
app.component('Branch',Branch);
app.component('branch_edit',BranchEdit);
app.component('account_edit',AccountEdit);
app.component('map_branch',FrontbranchMap);
app.component('frontend_reservation',FrontReservation);

// owner
app.component('account_owner',AccountOwner);
app.component('account_edit_owner',AccountEditOwner);
app.component('post_owner',PostOwner);
app.component('post_edit_owner',PostEditOwner);
app.mount('#app');
