import axios from "axios";
window._ = require('lodash');


import Admin from "./components/Admin";

import App from "./components/App";
import Tests from "./components/Tests";
import AdminUpdate from "./components/AdminUpdate";

// import UserComment from "./components/UserComment";  //for add comment
import Comment from "./components/comments/Comment";
import ShowComment from "./components/comments/index/ShowComment";

try {
    require('bootstrap');
} catch (e) {}

import  "../scss/main.scss";
import "../js/main.js";
