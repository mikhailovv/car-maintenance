import React, {useState} from 'react';
import {AppBar, Avatar, Box, Button, IconButton, Menu, MenuItem, Toolbar, Typography} from "@mui/material";
import {useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {logout} from "../../feature/auth/authSlice";
import MenuIcon from '@mui/icons-material/Menu';


const Header = () => {
    const dispatch = useDispatch();
    const [anchorEl, setAnchorEl] = useState(null);
    const [userMenuAnchorEl, setUserMenuAnchorEl] = useState(null);
    const navigate = useNavigate();
    const user = useSelector(state => state.auth.user);

    const handleMenuOpen = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleMenuClose = () => {
        setAnchorEl(null);
    };

    const handleNavigation = (route) => {
        navigate(route);
        handleMenuClose();
    };

    const handleUserMenuOpen = (event) => {
        setUserMenuAnchorEl(event.currentTarget);
    }
    const handleUserMenuClose = () => {
        setUserMenuAnchorEl(null);
    }

    const handleLogout = () => {
        console.log('Logging out');
        dispatch(logout());
        navigate('/login');
        handleMenuClose();
    };

    return (
        <AppBar position="sticky">
            <Toolbar sx={{paddingLeft:0}}>
                {/*/!* Mobile Navigation *!/*/}
                <Button sx={{ display: {md: 'none'} }} edge="end" color="inherit"  onClick={handleMenuOpen}>
                    <MenuIcon />
                </Button>
                <Typography variant="h6" sx={{ flexGrow: 1 }}>
                    CarCare
                </Typography>

                {/* Desktop Navigation */}
                <Box sx={{ display: { xs: 'none', md: 'flex' } }}>
                    <Button color="inherit" onClick={() => handleNavigation('/')}>Home</Button>
                    {user && <Button color="inherit" onClick={() => handleNavigation('/cars')}>Cars</Button>}
                </Box>



                <Menu
                    anchorEl={anchorEl}
                    open={Boolean(anchorEl)}
                    onClose={handleMenuClose}
                >
                    <MenuItem onClick={() => handleNavigation('/')}>Home</MenuItem>
                    {user && <MenuItem onClick={() => handleNavigation('/cars')}>Cars</MenuItem>}
                </Menu>

                {/* Show menu options only if the user is logged in */}
                {user ? (
                    <>
                        <Button color="inherit" onClick={() => navigate('/dashboard')}>{user.name}</Button>
                        <IconButton color="inherit" onClick={handleUserMenuOpen}>
                            <Avatar alt={user.name} src={user.avatar} />
                        </IconButton>

                        <Menu anchorEl={userMenuAnchorEl} open={Boolean(userMenuAnchorEl)} onClose={handleUserMenuClose}>
                            <MenuItem onClick={handleUserMenuClose}>{user.email}</MenuItem>
                            <MenuItem>User settings</MenuItem>
                            <MenuItem onClick={handleLogout}>Logout</MenuItem>
                        </Menu>
                    </>
                ) : (
                    <Button color="inherit" onClick={() => navigate('/login')}>
                        Login
                    </Button>
                )}
            </Toolbar>
        </AppBar>
    );
};

export default Header;