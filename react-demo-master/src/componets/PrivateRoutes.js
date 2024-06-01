import { Outlet, Navigate } from 'react-router-dom'

const PrivateRoutes = () => {
    let isLogin = localStorage.getItem('data');
    return(
        isLogin ? <Outlet/> : <Navigate to="/login"/>
    )
}

export default PrivateRoutes