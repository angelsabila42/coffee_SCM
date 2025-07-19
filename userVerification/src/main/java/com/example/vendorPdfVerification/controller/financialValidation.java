package com.example.vendorPdfVerification.controller;
import com.example.vendorPdfVerification.model.UserData;
import java.io.*;
import java.util.regex.Pattern;

import org.apache.pdfbox.text.PDFTextStripper;

public class financialValidation {


        //public  boolean isFinancialStatement(String userName,String imageContent) {

           //String textNoSpaces = imageContent.replaceAll("\\s+", "").toUpperCase();
               
        //try {


             // Check for key features
        //     boolean hasHeader = imageContent.contains("FINANCIALSTATEMENT") || imageContent.contains("STATEMENTOFACCOUNT")&& imageContent.contains(userName.toUpperCase());

        //     boolean hasDate = Pattern.compile("STATEMENT(OF)?PERIOD[:.]\\d{2}[-/]\\d{2}[-/]\\d{4}-\\d{2}[-/]\\d{2}[-/]\\d{4}")
        //             .matcher(imageContent).find();
        //     boolean hasUserName = imageContent.contains(userName);

        //     boolean hasTableHeaders = imageContent.contains("DATE") && imageContent.contains("DESCRIPTION") && imageContent.contains("AMOUNT");

        //     boolean hasCurrency = Pattern.compile("(UGX|USD|KSH)?\\d{1,3}(,\\d{3})*(.\\d{2})?")
        //             .matcher(imageContent).find();

        //                     if (!hasHeader) System.out.println("Missing header");
        // if (!hasDate) System.out.println("Missing date range");
        // if (!hasTableHeaders) System.out.println("Missing table headers");
        // if (!hasCurrency) System.out.println("Missing currency");
        //       return hasHeader && hasDate && hasTableHeaders && hasCurrency && hasUserName;
      
            
        // }

           
        //  catch (Exception e) {
        //     System.err.println(" PDF read error: " + e.getMessage());
        //     return false;
        // }
  //  }
  public boolean isFinancialStatement(String userName, String imageContent) {
    try {
        String contentClean = imageContent.replaceAll("\\s+", "").toUpperCase();

        boolean hasHeader = contentClean.contains("FINANCIALSTATEMENT") && imageContent.toUpperCase().contains(userName.toUpperCase());

        boolean hasDate = Pattern.compile("STATEMENT\\s*OF\\s*PERIOD\\s*[:.]\\s*\\d{2}[-/]\\d{2}[-/]\\d{4}")
                .matcher(imageContent.toUpperCase()).find();

        boolean hasUserName = imageContent.toUpperCase().contains(userName.toUpperCase());

        boolean hasTableHeaders = imageContent.toUpperCase().contains("DATE") || imageContent.toUpperCase().contains("DESCRIPTION");

        boolean hasCurrency = Pattern.compile("(UGX|USD|KSH)?\\s*\\d{2,}([.,]\\d{3}){2,}").matcher(imageContent).find();

        return hasHeader && hasDate && hasUserName && hasCurrency && hasTableHeaders;
    } catch (Exception e) {
        System.err.println(" PDF read error: " + e.getMessage());
        return false;
    }
}


    
}
