import { Field, Form, Formik } from "formik";
import React from "react";
import { Link } from "react-router-dom";
import * as Yup from "yup";
import axios from "axios";
import { Button } from "react-bootstrap";

function Registration() {
  const ResgisterForm = Yup.object().shape({
    first_name: Yup.string().required("Required").min(2, "Too Short!"),
    last_name: Yup.string().min(2, "Too Short!").required("Required"),
    email: Yup.string().email().required("Required"),
    password: Yup.string()
      .matches(
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/,
        "Must Contain 8 Characters, One Uppercase, One Lowercase, One Number and one special case Character"
      )
      .required("Required"),
    confirm_password: Yup.string()
      .oneOf([Yup.ref("password"), null], "Passwords must match")
      .required("Required"),
  });

  return (
    <>
      <div className="container">
        <div className="row">
          <div className="registration_form">
          <h1>Registration</h1>

          <Formik
            initialValues={{
              email: "",
              first_name: "",
              last_name: "",
              password: "",
              confirm_password: "",
            }}
            validationSchema={ResgisterForm}
            onSubmit={(values) => {
              // console.log(values);

              const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ values }),
              };
              axios
                .post("http://143.110.254.46:8999/user/register/", values)
                .then((data) => console.log(data.id));
            }}
          >
            {({ errors, touched, handleSubmit }) => (
              <Form onSubmit={handleSubmit}>
                <Field placeholder="First Name" name="first_name" type="text" />
                {errors.first_name && touched.first_name ? (
                  <div style={{ color: "red" }}>{errors.first_name}</div>
                ) : null}
                <br />
                <br />
                <Field placeholder="Last Name" name="last_name" type="text" />
                {errors.last_name && touched.last_name ? (
                  <div style={{ color: "red" }}>{errors.last_name}</div>
                ) : null}
                <br />
                <br />
                <Field placeholder="Email" name="email" type="email" />
                {errors.email && touched.email ? (
                  <div style={{ color: "red" }}>{errors.email}</div>
                ) : null}
                <br />
                <br />
                <Field placeholder="Password" name="password" type="password" />
                {errors.password && touched.password ? (
                  <div style={{ color: "red" }}>{errors.password}</div>
                ) : null}
                <br />
                <br />
                <Field
                  placeholder="Confirm Password"
                  name="confirm_password"
                  type="password"
                />
                {errors.confirm_password && touched.confirm_password ? (
                  <div style={{ color: "red" }}>{errors.confirm_password}</div>
                ) : null}
                <br />
                <br />
                <Button className="btn" type="submit">
                  Registration
                </Button>
              </Form>
            )}
          </Formik>
          <div>
            <h4>
              Already have an account? <Link to="/login">Sign In Now</Link>
            </h4>
          </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default Registration;
