import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import LoginForm from './components/LoginForm/LoginForm';
import RegistrationForm from './components/RegistrationForm/RegistrationForm';
import CarList from './components/CarList/CarList'
import AddServicePage from "./pages/AddServicePage/AddServicePage";
import EditServicePage from "./pages/EditServicePage/EditServicePage";
import AddPartPage from "./pages/AddPartPage/AddPartPage";
import CarDetailsPage from "./pages/CarDetailsPage/CarDetailsPage";

function App() {
  return (
      <Router>
        <Routes>
          <Route path="/login" element={<LoginForm />} />
          <Route path="/register" element={<RegistrationForm />} />
          <Route path="/cars" element={<CarList />} />
          <Route path="/cars/:id" element={<CarDetailsPage />} />
          <Route path="/cars/:id/services/add" element={<AddServicePage />} />
          <Route path="/services/edit/:id" element={<EditServicePage />} />
          <Route path="/cars/:id/parts/add" element={<AddPartPage />} />
        </Routes>
      </Router>
  );
}

export default App;