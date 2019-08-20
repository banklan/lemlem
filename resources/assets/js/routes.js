import Welcome from './components/Welcome'
import Order from './components/Order'
import MakeOrders from './components/MakeOrders'
import cuisineShow from './components/cuisineShow'
// import cuisineTest from './components/CuisineTest'
import outletShow from './components/OutletShow'
import Home from './components/Home'
import MyOrders from './components/MyOrders'
import MyOrderShow from './components/MyOrderShow'
import Checkout from './components/Checkout'
import AdminDashboard from './components/Admin/Home'
import AdminList from './components/Admin/AdminList'
import Bearers from './components/Admin/Bearers'
import AdminShow from './components/Admin/AdminShow'
import BearerShow from './components/Admin/BearerShow'
import ClientUsers from './components/Admin/UsersList'
import ClientUserShow from './components/Admin/ClientUserShow'
import adminOutlets from './components/Admin/adminOutlets'
import adminOutletShow from './components/Admin/AdminOutletShow'
import adminCities from './components/Admin/Cities'
import adminLocations from './components/Admin/Locations'

export default[
    {path: '/', name: 'Welcome', component: Welcome},
    {path: '/order', name: 'Order', component: Order},
    {path: '/make_orders', name: 'MakeOrders', component: MakeOrders},
    // {path: '/cuisine/', component: cuisineTest},
    {path: '/cuisine/:id/:name', name: 'cuisineShow', component: cuisineShow},
    {path: '/outlets/:id/:name', name: 'outletShow', component: outletShow,},
    {path: '/home', name: 'home', component: Home},
    {path: '/my_orders', name: 'MyOrders', component: MyOrders},
    {path: '/my_orders/:id', name: 'MyOrderShow', component: MyOrderShow},
    {path: '/checkout', name: 'checkout', component: Checkout},
    {path: '/admin', name: 'AdminDashboard', component: AdminDashboard},
    {path: '/admin/users/admins', name: 'AdminList', component: AdminList},
    {path: '/admin/users/admin/:id', name: 'adminShow', component: AdminShow},
    {path: '/admin/users/bearers', name: 'Bearers', component: Bearers},
    {path: '/admin/users/bearer/:id', name: 'bearerShow', component: BearerShow},
    {path: '/admin/users/client_users', name: 'clientUsers', component: ClientUsers},
    {path: '/admin/users/client_user/:id', name: 'clientUserShow', component: ClientUserShow},
    {path: '/admin/outlets', name: 'adminOutlets', component: adminOutlets},
    {path: '/admin/outlet/:id', name: 'adminOutletShow', component: adminOutletShow},
    {path: '/admin/cities', name: 'adminCities', component: adminCities},
    {path: '/admin/locations', name: 'adminLocations', component: adminLocations},
]
