package com.example.vendorPdfVerification.model;

import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;
import lombok.experimental.PackagePrivate;
 @Data
public class UserData {
     @NotBlank
     private String UserName;

    // @Email
    // @NotBlank
    // private String email;

        
    // @NotBlank
    // private String password;

     @NotBlank
     private String id;
     private String idname;

     @NotBlank
     private String financialStatus;
     private String financialStatusName;

     @NotBlank
     private String ucdaCertificate;
     private String ucdaCertificateName;
    //@NotBlank 
    // private String id;
    // private String idName;
}
