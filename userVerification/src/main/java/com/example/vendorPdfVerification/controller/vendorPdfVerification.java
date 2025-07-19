package com.example.vendorPdfVerification.controller;

import jakarta.validation.Valid;
import java.io.*;
import java.io.FileOutputStream;
import java.util.Base64;

import org.apache.coyote.BadRequestException;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import com.example.vendorPdfVerification.model.UserData;
@RestController
@RequestMapping("/api")

public class vendorPdfVerification {

     @PostMapping("/verify")
    public ResponseEntity<?> verifyVendorPDF(@Valid @RequestBody UserData data) { 

   
   
String[][] pdfs = {
    {data.getId(), data.getIdname(), "ID"},
    {data.getUcdaCertificate(), data.getUcdaCertificateName(), "UCDA"},
    {data.getFinancialStatus(), data.getFinancialStatusName(), "FINANCIAL_STATEMENT"}
};
  String extractedText = "";
StringBuilder result = new StringBuilder();

boolean allValid = true; // Track overall validity

  String userName = data.getUserName();
       if (userName == null || userName.trim().isEmpty()) {
      result.append("User name is missing.\n");
        
     allValid = false; 
      
   }


for (String[] pdfInfo : pdfs) {
    String pdfBase64 = pdfInfo[0];
    String pdfName = pdfInfo[1] != null && !pdfInfo[1].isEmpty() ? pdfInfo[1] : "upload.pdf";
    String pdfType = pdfInfo[2];

    if (pdfBase64 == null || pdfBase64.trim().isEmpty()) {
         result.append(pdfType).append(" PDF file is missing or empty.\n");
       
         allValid = false; 
         continue;
     }
  
     byte[] decoded;
     try {
         decoded = Base64.getDecoder().decode(pdfBase64);
         if (decoded.length < 4) {
             result.append(pdfType).append(" decoded file is too short.\n");
           
            allValid = false; 
             continue;
         }
         String header = new String(decoded, 0, 4);
         if (!header.equals("%PDF")) { 
             result.append(pdfType).append(" is not a valid PDF file.\n");
           
            allValid = false; 
             continue;
         }


  
        

         PdfToImage converter = new PdfToImage();
         String pdfSavePath = "pdf_uploads/" + pdfName;
           extractedText = converter.convertPdfToImage(decoded, pdfSavePath, pdfName);
         boolean isValid = false;
         switch (pdfType) {
             case "ID":
                 idVerification idVerifier = new idVerification();
                 isValid = idVerifier.verifyUgandanNationalId(data.getUserName().toUpperCase().trim(), extractedText.replaceAll("\\s+", "").toUpperCase());
                   result.append("Extracted Text from ").append(pdfType).append(" (").append(pdfName).append("):\n")
                 .append(extractedText).append("\nIs valid? ").append(isValid).append("\n\n");
                 break;
             case "UCDA":
                 UCDAvalidation ucdaVerifier = new UCDAvalidation();
                 isValid = ucdaVerifier.isValidUCDACertificate(data.getUserName().toUpperCase().trim(), extractedText.replaceAll("\\s+", "").toUpperCase());
                  result.append("Extracted Text from ").append(pdfType).append(" (").append(pdfName).append("):\n")
                 .append(extractedText).append("\nIs valid? ").append(isValid).append("\n\n");
                 break;
             case "FINANCIAL_STATEMENT":
                 financialValidation financialVerifier = new financialValidation();
                 isValid = financialVerifier.isFinancialStatement(data.getUserName().toUpperCase().trim(), extractedText.replaceAll("\\s+", "").toUpperCase());
                  result.append("Extracted Text from ").append(pdfType).append(" (").append(pdfName).append("):\n")
                 .append(extractedText).append("\nIs valid? ").append(isValid).append("\n\n");
                 break;
         }
//  result.append("Extracted Text from ").append(pdfType).append(" (").append(pdfName).append("):\n")
//        .append(extractedText).append("\nIs valid? ").append(isValid).append("\n\n");
           if (!isValid) {
             result.append(pdfType).append(" validation failed.\n");
             allValid = false;
         } else {
             result.append(pdfType).append(" validation succeeded.\n");
         }


     } catch (Exception e) {
         result.append("Error processing ").append(pdfType).append(" (").append(pdfName).append("): ").append(e.getMessage()).append("\n");
     }
   }
    if (allValid) {
     return ResponseEntity.ok("Validation successful.");
 } else {
    // return ResponseEntity.badRequest().body(result.toString());
     return ResponseEntity.ok(result.toString() );
  }
   }
     
  }





   

