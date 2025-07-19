package com.example.vendorPdfVerification.controller;


import java.util.regex.Pattern;


public class UCDAvalidation {
    public  boolean isValidUCDACertificate(String UserName,String imageContent) {
        try  {
            

            boolean hasHeader = imageContent.contains("UGANDACOFFEEDEVELOPMENTAUTHORITY");
              boolean hasUserName = imageContent.contains(UserName);

            boolean hasCertificateNumber = Pattern.compile("CERTIFICATENO[:]UCDA/EXP/\\d{3,6}")
                    .matcher(imageContent).find();

            boolean hasExporter = imageContent.contains("EXPORTER") || imageContent.contains("NAMEOFEXPORTER");
            boolean hasDestination = imageContent.contains("DESTINATION") || imageContent.contains("COUNTRYOFDESTINATION");
            boolean hasCoffeeInfo = imageContent.contains("GRADE") && imageContent.contains("TYPE") && imageContent.contains("QUANTITY");

            return hasHeader && hasCertificateNumber && hasExporter && hasDestination && hasCoffeeInfo && hasUserName;

        } catch (Exception e) {
            System.err.println("PDF read error: " + e.getMessage());
            return false;
        }
    }
}
