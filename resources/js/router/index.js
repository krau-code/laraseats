import { createRouter, createWebHistory } from "vue-router";

// Pages
import HomePage from '../components/pages/HomePage.vue';
import MoviePage from '../components/pages/MoviePage.vue';
import MovieSchedule from '../components/pages/MovieSchedule.vue';
import SafetyPage from '../components/pages/SafetyPage.vue';
import SchedulesPage from '../components/pages/SchedulesPage.vue';
import ScheduleReserve from '../components/pages/ScheduleReserve.vue';
import ReservationSuccess from '../components/pages/ReservationSuccess.vue';

// Admin
import AdminLogin from '../components/admins/AdminLogin.vue';
import AdminRegister from '../components/admins/AdminRegister.vue';
import AdminIndex from '../components/admins/AdminIndex.vue';
import AdminLogout from '../components/admins/AdminLogout.vue';

// Reservations
import ReservationsIndex from '../components/reservations/ReservationsIndex.vue';
import ReservationsPick from '../components/reservations/ReservationsPick.vue';
import ReservationsCreate from '../components/reservations/ReservationsCreate.vue';
import ReservationsEdit from '../components/reservations/ReservationsEdit.vue';

// Movies
import MoviesIndex from '../components/movies/MoviesIndex.vue';
import MoviesShow from '../components/movies/MoviesShow.vue';
import MoviesCreate from '../components/movies/MoviesCreate.vue';
import MoviesEdit from '../components/movies/MoviesEdit.vue';

// Cinemas
import CinemasIndex from '../components/cinemas/CinemasIndex.vue';
import CinemasCreate from '../components/cinemas/CinemasCreate.vue';
import CinemasEdit from '../components/cinemas/CinemasEdit.vue';

// Schedules
import SchedulesIndex from '../components/schedules/SchedulesIndex.vue';
import SchedulesCreate from '../components/schedules/SchedulesCreate.vue';
import SchedulesEdit from '../components/schedules/SchedulesEdit.vue';

import PageNotFound from '../components/PageNotFound.vue';

const routes = [
    // Pages
    {
        path: '/',
        name: 'home',
        component: HomePage
    },
    {
        path: '/movie/:id',
        name: 'movie',
        component: MoviePage,
        props: true,
    },
    {
        path: '/movie/schedule/:id/:title',
        name: 'movie.schedule',
        component: MovieSchedule,
        props: true,
    },
    {
        path: '/safety',
        name: 'safety',
        component: SafetyPage
    },
    {
        path: '/schedules',
        name: 'schedules',
        component: SchedulesPage
    },
    {
        path: '/schedules/reserve/:sched',
        name: 'schedule.reserve',
        component: ScheduleReserve,
        props: true,
    },
    {
        path: '/schedules/reservation/success',
        name: 'reserve.success',
        component: ReservationSuccess,
    },
    // Admin
    {
        path: '/admin/login',
        name: 'admin.login',
        component: AdminLogin,
    },
    {
        path: '/admin/register',
        name: 'admin.register',
        component: AdminRegister,
    },
    {
        path: '/admin',
        name: 'admin.index',
        component: AdminIndex,
    },
    {
        path: '/admin/logout',
        name: 'admin.logout',
        component: AdminLogout,
    },
    // Reservations
    {
        path: '/admin/reservations',
        name: 'reservations.index',
        component: ReservationsIndex,
    },
    {
        path: '/admin/reservations/pick',
        name: 'reservations.pick',
        component: ReservationsPick,
    },
    {
        path: '/admin/reservations/create',
        name: 'reservations.create',
        component: ReservationsCreate,
        props: true,
    },
    {
        path: '/admin/reservations/:id/edit',
        name: 'reservations.edit',
        component: ReservationsEdit,
        props: true,
    },
    // Movies
    {
        path: '/admin/movies',
        name: 'movies.index',
        component: MoviesIndex,
    },
    {
        path: '/admin/movies/:id',
        name: 'movies.show',
        component: MoviesShow,
        props: true,    
    },
    {
        path: '/admin/movies/create',
        name: 'movies.create',
        component: MoviesCreate,
    },
    {
        path: '/admin/movies/:id/edit',
        name: 'movies.edit',
        component: MoviesEdit,
        props: true,
    },
    // Cinemas
    {
        path: '/admin/cinemas',
        name: 'cinemas.index',
        component: CinemasIndex,
    },
    {
        path: '/admin/cinemas/create',
        name: 'cinemas.create',
        component: CinemasCreate,
    },
    {
        path: '/admin/cinemas/:id/edit',
        name: 'cinemas.edit',
        component: CinemasEdit,
        props: true,
    },
    // Schedules
    {
        path: '/admin/schedules',
        name: 'schedules.index',
        component: SchedulesIndex,
    },
    {
        path: '/admin/schedules/create',
        name: 'schedules.create',
        component: SchedulesCreate,
    },
    {
        path: '/admin/schedules/:id/edit',
        name: 'schedules.edit',
        component: SchedulesEdit,
        props: true,
    },
    // Catch all 404
    {
        path: '/:catchAll(.*)',
        name: 'pageNotFound',
        component: PageNotFound
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
});