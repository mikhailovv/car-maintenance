import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import LoginForm from './components/LoginForm/LoginForm';
import CarList from './components/CarList/CarList';
import AddServicePage from './pages/AddServicePage/AddServicePage';
import AddPartPage from './pages/AddPartPage/AddPartPage';
import CarDetailsPage from './pages/CarDetailsPage/CarDetailsPage';
import HomePage from './pages/HomePage/HomePage';
import Header from './components/Header/Header';
import SignUpPage from './pages/SignUpPage/SignUpPage';
import ProtectedRoute from './components/ProtectedRoute/ProtectedRoute';

function App() {
  return (
    <Router>
      <Header />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/signUp" element={<SignUpPage />} />
        <Route path="/login" element={<LoginForm />} />
        <Route path="/cars" element={<ProtectedRoute><CarList /></ProtectedRoute>} />
        <Route path="/cars/:id" element={<ProtectedRoute><CarDetailsPage /></ProtectedRoute>} />
        <Route path="/cars/:id/services/add" element={<ProtectedRoute><AddServicePage /></ProtectedRoute>} />
        <Route path="/services/edit/:id" element={<ProtectedRoute>EditServicePage /></ProtectedRoute>} />
        <Route path="/cars/:id/parts/add" element={<ProtectedRoute><AddPartPage /></ProtectedRoute>} />
      </Routes>
    </Router>
  );
}

export default App;