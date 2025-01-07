import { configureStore } from '@reduxjs/toolkit';
import authReducer from './feature/auth/authSlice';

const store = configureStore({
    reducer: {
        auth: authReducer, // Add your auth slice here
    },
});

export default store;
