package com.example.vendorPdfVerification.controller;


import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.rendering.PDFRenderer;
import org.apache.pdfbox.rendering.*;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.ResponseBody;

import com.ibm.websphere.zos.request.logging.UserData;

import jakarta.validation.Valid;

import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileOutputStream;
import java.util.UUID;

public class PdfToImage {
    public String convertPdfToImage(byte[] content,String filepath, String pdfname) throws Exception {

            
            String uniquename = UUID.randomUUID().toString() + "-"+ pdfname;


         File file = new File(filepath);
          try (FileOutputStream pdf = new FileOutputStream(file)) {
          pdf.write(content);
    }
        PDDocument document = PDDocument.load(file);
       PDFRenderer Renderer = new PDFRenderer(document);

       File pdfImagesFolder = new File("pdf_images");
       if (!pdfImagesFolder.exists()) {
           pdfImagesFolder.mkdirs(); 
       }
        
        BufferedImage image = Renderer.renderImageWithDPI(0, 300, ImageType.GRAY); // page 0 at 300 DPI
        File outputImage = new File(pdfImagesFolder, uniquename + ".png");
        ImageIO.write(image, "PNG", outputImage);


        String imagePath = outputImage.getAbsolutePath();
        orcservice crservice = new orcservice();
         String ocrText =  crservice.performOCR(imagePath);

        document.close();
//         System.out.println("PDF converted to image successfully: " + uniquename + ".png");
//         System.out.println("Saving PDF to: " + file.getAbsolutePath());
// System.out.println("Saving image to: " + pdfImagesFolder.getAbsolutePath());

return ocrText;

}


}



