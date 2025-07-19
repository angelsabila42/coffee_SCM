package com.example.vendorPdfVerification.controller;
 import java.util.regex.*;
 import java.io.* ;
public class idVerification {


      public boolean verifyUgandanNationalId(String UserName,String imageContent) {
   

//     try {
        
//         String[] lines = imageContent.toUpperCase().split("\\r?\\n");

//         boolean hasHeader = false;
//         boolean hasNationalityBlock = false;
//         boolean hasNIN = false;
//         boolean hasCardNumber = false;
//         boolean hasDates = false;

//         for (int i = 0; i < lines.length; i++) {
//             String line = lines[i].trim();

//             // Basic headers
//             if (line.contains("REPUBLIC OF UGANDA") && line.contains("NATIONAL ID")) {
//                 hasHeader = true;
//             }

//             // Look for NIN
//             if (line.matches(".*[A-Z]{2}\\d{6}[A-Z0-9]{5}.*")) {
//                 hasNIN = true;
//             }

//             // Look for CARD NO
//            if (line.contains("CARD NO") && i + 1 < lines.length) {
//            String nextLine = lines[i + 1].trim();
//            Matcher matcher = Pattern.compile("\\b\\d{10}\\b").matcher(nextLine);
//     if (matcher.find()) {
//         hasCardNumber = true;
//     }
// }


//             // Look for DOB, Nationality, Sex on the same/next line
//             if (line.contains("NATIONALITY") && line.contains("SEX") && line.contains("DATE OF BIRTH")) {
//                 if (i + 1 < lines.length) {
//                     String valueLine = lines[i + 1].trim();
//                     if (valueLine.matches("UGA\\s+[MF]\\s+\\d{2}[./-]\\d{2}[./-]\\d{4}")) {
//                         hasNationalityBlock = true;
//                     }
//                 }
//             }

//             // Look for dates like expiry and DOB elsewhere
//             if (line.matches(".*\\d{2}[./-]\\d{2}[./-]\\d{4}.*")) {
//                 hasDates = true;
//             }
//         }

//         return hasHeader && hasNIN && hasNationalityBlock && hasCardNumber && hasDates;

//     } catch (Exception e) {
//         e.printStackTrace();
//    }
//    return false;


    if (imageContent == null) return false;

    String textNoSpaces = imageContent.replaceAll("\\s+", "").toUpperCase();

    boolean hasHeader = textNoSpaces.contains("REPUBLICOFUGANDA") && textNoSpaces.contains("NATIONALID");

    Pattern ninPattern = Pattern.compile("[A-Z]{2}[A-Z0-9]{13}");
    Matcher ninMatcher = ninPattern.matcher(imageContent);
    boolean hasNIN = ninMatcher.find();

    Pattern cardPattern = Pattern.compile("\\b\\d{9}\\b");
    Matcher cardMatcher = cardPattern.matcher(imageContent);
    boolean hasCardNumber = cardMatcher.find();

    boolean hasNationality = imageContent.contains("NATIONALITY");
    boolean hasSex = imageContent.contains("SEX");
    boolean hasDOB = textNoSpaces.contains("DATEOFBIRTH");
   
   // boolean hasUserName = imageContent.contains(UserName);
    Pattern datePattern = Pattern.compile("\\d{2}[./-]\\d{2}[./-]\\d{4}");
    Matcher dateMatcher = datePattern.matcher(imageContent);
    boolean hasDates = dateMatcher.find();
     boolean hasNationalityBlock = hasNationality && hasSex && hasDOB;// && hasUserName;


     System.out.println("Header: " + hasHeader);
System.out.println("NIN: " + hasNIN);
System.out.println("Card Number: " + hasCardNumber);
System.out.println("Nationality block: " + hasNationalityBlock);
System.out.println("Dates: " + hasDates);

    return hasHeader && hasNIN && hasNationalityBlock  && hasDates && hasCardNumber;

    
}


}


    

