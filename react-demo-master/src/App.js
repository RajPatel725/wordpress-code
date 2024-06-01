import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './componets/Home';
import Navbar from './componets/Navbar';
import Blog from './blog/Blog';
import PrivateRoutes from './componets/PrivateRoutes';
import CreateUser from './crud/CreateUser';
import EditUser from './crud/EditUser';
import Filter from './crud/Filter';
import AddUser from './crud/AddUser';
import Single from './blog/Single';
import RepeaterForm from './componets/RepeaterForm';
import Product from './props/Product';
import Modal from './componets/Modal';
import MainForm from './componets/MainForm';
import Countrystatecity from './componets/Countrystatecity';
import Lifecycle from './life_cycle/Lifecycle';
import Did_mount from './life_cycle/Did_mound';
import Purecomponent from './life_cycle/PureComponent';
import Useeffect from './hooks/Useeffect';
import MemoH from './hooks/MemoH';
import RefH from './hooks/RefH';
import Hoc from './hooks/Hoc';
import PageNotFound from './componets/PageNotFound';
import Login from './author/SignIn';
import Registration from './author/Signup';
import PreState from './previous-value/PreState';
import StateWithObject from './componets/StateWithObject';
import PromiseCompo from './componets/PromiseCompo';
import UseCallBack from './hooks/UseCallBack';
import Accordion from './componets/Accordion';
import Filter_Regular_Expression from './componets/Filter_Regular_Expression';
import LoadMore from './loadMore/LoadMore';
import ScrollLoadMore from './loadMore/ScrollLoadMore';
import TrafficSignal from './componets/TrafficSignal';
import CheckBox from './checkBox/CheckBox';

function App() {

  let isLogout = localStorage.getItem('data');

  const routing = [
    {
      Path: "/",
      component: <Home />
    },
    {
      Path: "/blog",
      component: <Blog />
    },
    {
      Path: "/user/add",
      component: <AddUser />
    },
    {
      Path: "/user",
      component: <CreateUser />
    },
    {
      Path: "/user/edit/:id",
      component: <EditUser />
    },
    {
      Path: "/user/filter",
      component: <Filter />
    },
    {
      Path: "/blog/single/:id",
      component: <Single />
    },
    {
      Path: "/filter-regular-expression",
      // eslint-disable-next-line react/jsx-pascal-case
      component: <Filter_Regular_Expression />
    },
    {
      Path: "/dynamic-form",
      component: <RepeaterForm />
    },
    {
      Path: "/products",
      component: <Product />
    },
    {
      Path: "/modal",
      component: <Modal />
    },
    {
      Path: "/main-form",
      component: <MainForm />
    },
    {
      Path: "/country-state-city",
      component: <Countrystatecity />
    },
    {
      Path: "/life-cycle",
      component: <Lifecycle />
    },
    {
      Path: "/did-mount",
      // eslint-disable-next-line react/jsx-pascal-case
      component: <Did_mount />
    },
    {
      Path: "/use-effect",
      component: <Useeffect />
    },
    {
      Path: "/pure-component",
      component: <Purecomponent />
    },
    {
      Path: "/memo-hooks",
      component: <MemoH />
    },
    {
      Path: "/useref-hooks",
      component: <RefH />
    },
    {
      Path: "/hoc",
      component: <Hoc />
    },
    {
      Path: "*",
      component: <PageNotFound />
    },
    {
      Path: "/pre-state-value",
      component: <PreState />
    },
    {
      Path: "/state-with-object",
      component: <StateWithObject />
    },
    {
      Path: "/promise-component",
      component: <PromiseCompo />
    },
    {
      Path: "/use-call-back",
      component: <UseCallBack />
    },
    {
      Path: "/accordion",
      component: <Accordion />
    },
    {
      Path: "/loadmore",
      component: <LoadMore />
    },
    {
      Path: "ScrollLoadMore",
      component: <ScrollLoadMore />
    },
    {
      Path: "traffic-signal",
      component: <TrafficSignal />
    },
    {
      Path: "check-box",
      component: <CheckBox />
    } 
  ];

  return (
    <>
      <div className="App">
        <BrowserRouter>
          <Navbar />
          <Routes>
            <Route element={<PrivateRoutes />}>
              {
                routing.map((item, index) => {
                  return <Route key={index} exact path={item.Path} element={item.component} />
                })
              }
            </Route>
            {isLogout ? null
              :
              <>
                <Route path='/login' exact element={<Login />} />
                <Route path='/registration' exact element={<Registration />} />
              </>
            }
          </Routes>
        </BrowserRouter>
      </div>
    </>
  );
}

export default App;
