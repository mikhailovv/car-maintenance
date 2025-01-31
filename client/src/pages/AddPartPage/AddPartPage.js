import React from 'react';
import PartForm from "../../components/PartForm/PartForm";
import {useNavigate, useParams} from "react-router-dom";
import api from "../../utils/api";

const AddPartPage = () => {
    const navigate = useNavigate();
    const {id} = useParams();

    const handleSave = async (newPart) => {
        try {
            api.post('/api/parts', {body: JSON.stringify( newPart)})
                .then(() => navigate(`/cars/${id}`))

        } catch (error) {
            console.error('Failed to save part:', error);
        }
    }

    return <PartForm selectedCarId={id} onSave={handleSave} />;
}

export default AddPartPage;