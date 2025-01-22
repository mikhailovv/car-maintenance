import React, {useEffect, useState} from 'react';
import {FormControl, InputLabel, MenuItem, Select} from "@mui/material";
import api from "../../utils/api";


const PartCategorySelect = () => {
    const [categories, setCategories] = useState([]);
    const [selectedCategory, setSelectedCategory] = useState('');

    useEffect(() => {
        api.get('/api/parts/categories/')
            .then(function(data){ setCategories(data)})
            .catch(err => console.error(err));
    }, [])

    const handleChange = (event) => {
        setSelectedCategory(event.target.value)
        console.log("Selected Category ID:", event.target.value);
    }

    return (
        <FormControl fullWidth>
            <InputLabel>Select Category</InputLabel>
            <Select value={selectedCategory || ""} onChange={handleChange}>
                <MenuItem value="">Select Category</MenuItem>
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