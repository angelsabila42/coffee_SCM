package com.example.vendorPdfVerification.controller;
 import net.sourceforge.tess4j.ITesseract;
import net.sourceforge.tess4j.Tesseract;
import net.sourceforge.tess4j.TesseractException;

import java.io.File;

import org.springframework.stereotype.Service;

@Service
public class orcservice {
   

        
    public String performOCR(String imagePath) {


       
//ProcessBuilder pb = new ProcessBuilder("tesseract", imagePath, "stdout", "--psm", "6", "-l", "eng");

               ITesseract tesseract = new Tesseract();

          String tessDataPath = System.getenv("TESSDATA_PREFIX");
        if (tessDataPath == null || tessDataPath.isEmpty()) {
            throw new RuntimeException("TESSDATA_PREFIX environment variable is not set.");
        }    
        tesseract.setDatapath(tessDataPath);
        tesseract.setLanguage("eng");
        tesseract.setPageSegMode(6);
    // System.out.println("Tesseract datapath: " + new File("C:/Program Files/Tesseract-OCR\\tessdata").getAbsolutePath());
        try {
            File imageFile = new File(imagePath);
            return tesseract.doOCR(imageFile);
        } catch (TesseractException e) {
            return "OCR Error: " + e.getMessage();
        }
    }

    }




