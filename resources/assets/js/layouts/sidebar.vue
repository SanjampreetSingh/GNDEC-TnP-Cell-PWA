<template>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <div class="user-profile">
                <div class="profile-img">
                    <img src="../../images/users/user.jpg" alt="user" /> </div>
                <div class="profile-text">
                    <a href="#">{{getAuthUsername()}}</a>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li>
                        <router-link to="/home" exact>
                            <i class="fa fa-home fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">Home</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="#" exact>
                            <i class="fa fa-file-word-o fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">Notice Maker</span>
                        </router-link>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="fa fa-file fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">Post
                                <i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">
                                <strong>
                                    <i class="fa fa-list fa-fw" aria-hidden="true"></i> Post Menu
                                </strong>
                            </li>
                            <li>
                                <router-link to="/post" exact>
                                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i> Add Posts
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/all" exact>
                                    <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> Manage Posts
                                </router-link>
                            </li>
                            <li>
                                <router-link to="#" exact>
                                    <i class="fa fa-thumb-tack fa-fw" aria-hidden="true"></i> Pinned Posts
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">User
                                <i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">
                                <strong>
                                    <i class="fa fa-list fa-fw" aria-hidden="true"></i> User Menu
                                </strong>
                            </li>
                            <li>
                                <router-link to="/excel" exact>
                                    <i class="fa fa-file-excel-o fa-fw" aria-hidden="true"></i> Add Users By Excel
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/single" exact>
                                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i> Add Single User
                                </router-link>
                            </li>
                            <li>
                                <router-link to="#" exact>
                                    <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> Manage Users
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="fa fa-graduation-cap fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">Students
                                <i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">
                                <strong>
                                    <i class="fa fa-list fa-fw" aria-hidden="true"></i> Students Menu
                                </strong>
                            </li>
                            <li>
                                <router-link to="#" exact>
                                    <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> Manage Students
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <i class="fa fa-building fa-fw" aria-hidden="true"></i>
                            <span class="hide-menu">Companies
                                <i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">
                                <strong>
                                    <i class="fa fa-list fa-fw" aria-hidden="true"></i> Companies Menu
                                </strong>
                            </li>
                            <li>
                                <router-link to="#" exact>
                                    <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> Manage Companies
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="sidebar-footer">
            <router-link to="/configuration" class="link" data-toggle="tooltip" title="Configuration">
                <i class="fa fa-cogs" aria-hidden="true"></i>
            </router-link>
            <router-link to="/profile" class="link" data-toggle="tooltip" title="Profile">
                <i class="fa fa-user" aria-hidden="true"></i>
            </router-link>
            <a href="/logout" class="link" data-toggle="tooltip" title="Logout" @click.prevent="logout">
                <i class="fa fa-power-off" aria-hidden="true"></i>
            </a>
        </div>
    </aside>
</template>

<script>
    import helper from '../services/helper'

    export default {
        mounted() {},
        methods: {
            logout() {
                helper.logout().then(() => {
                    this.$store.dispatch('resetAuthUserDetail');
                    this.$router.replace('/login')
                })
            },
            getAuthUsername() {
                return this.$store.getters.getAuthUsername;
            },
            getAuthUser(name) {
                return this.$store.getters.getAuthUser(name);
            }
        },
        computed: {
            getAvatar() {
                return '/images/users/' + this.getAuthUser('avatar');
            }
        }
    }
</script>