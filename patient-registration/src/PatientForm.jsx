import React, { useState } from 'react';
import PersonalDetails from './components/PersonalDetails';
import MedicalInformation from './components/MedicalInformation';
import CalculatedValues from './components/CalculatedValues';
import { Container } from './styles/ContainerStyles';

const PatientForm = () => {
  const [formData, setFormData] = useState({
    patientName: '',
    surname: '',
    dateOfBirth: '',
    gender: '',
    weight: '',
    height: '',
    respiratoryRate: '',
    bloodSugar: '',
    bmi: '',
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({ ...prevData, [name]: value }));
  };

  const calculateBMI = () => {
    const weight = parseFloat(formData.weight);
    const height = parseFloat(formData.height) / 100;
    if (weight && height) {
      const bmi = (weight / (height * height)).toFixed(2);
      setFormData((prevData) => ({ ...prevData, bmi }));
    }
  };

  return (
    <Container>
      <form>
        <PersonalDetails formData={formData} handleChange={handleChange} />
        <MedicalInformation
          formData={formData}
          handleChange={handleChange}
          calculateBMI={calculateBMI}
        />
        <CalculatedValues formData={formData} />
      </form>
    </Container>
  );
};

export default PatientForm;
