import { createSlice } from '@reduxjs/toolkit'

const initialState = {
    carList: []
}

const carsSlice = createSlice({
    name: 'cars',
    initialState,
    reducers: {
        setCarList(state, action) {
            state.carList = action.payload;
        },
    },
});

export const {setCarList} = carsSlice.actions;
export default carsSlice.reducer;