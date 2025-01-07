import {useEffect, useState} from "react";
import api from '../../utils/api'

const CarList = () => {
    const [cars, setCars] = useState([]);
    useEffect(() =>{
        api.get('/api/cars').then(setCars).catch(err => console.error(err));
    }, [])
    return (
        <template>
        <h1>Car list</h1>
        <ul>
            {cars.map(car => (
                <li key={car.id}>{car.brand} {car.model}</li>
            ))}
        </ul>
        </template>
    );
}

export default CarList;