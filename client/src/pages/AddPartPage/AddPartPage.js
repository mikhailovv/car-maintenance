import React from 'react';
import PartForm from "../../components/PartForm/PartForm";
import {useNavigate, useParams} from "react-router-dom";

const AddPartPage = () => {
    const navigate = useNavigate();
    const {id} = useParams();

    const handleSave = async (newPart) => {
        try {
            if (id !== '') {
                navigate(`/cars/${id}/services/add`);
            } else {
                navigate('/cars')
            }
        } catch (error) {
            console.error('Failed to save part:', error);
        }
    }

    return <PartForm onSave={handleSave}/>;
}

export default AddPartPage;