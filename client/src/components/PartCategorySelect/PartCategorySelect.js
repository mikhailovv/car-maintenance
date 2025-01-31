import React, {useEffect, useState} from 'react';
import {FormControl, InputLabel, MenuItem, Select} from "@mui/material";
import api from "../../utils/api";


const PartCategorySelect = ({selectedCategory, onChangeHandler}) => {
    const [categories, setCategories] = useState([]);

    useEffect(() => {
        api.get('/api/parts/categories/')
            .then(function(data){ setCategories(data)})
            .catch(err => console.error(err));
    }, [])


    return (

        <FormControl fullWidth sx={{mt:'16px'}}>
            <InputLabel>Select category</InputLabel>
            <Select value={selectedCategory || ""} onChange={onChangeHandler} >
                <MenuItem value="">Select category</MenuItem>
                {categories.flatMap((category) => [
                    <MenuItem key={`parent-${category.id}`} disabled>
                        {category.name}
                    </MenuItem>,
                    ...category.subcategories.map((sub) => (
                        <MenuItem key={sub.id} value={String(sub.id)} style={{ paddingLeft: 20 }}>
                            {sub.name}
                        </MenuItem>
                    ))
                ])}
            </Select>
        </FormControl>
    );
};

export default PartCategorySelect;