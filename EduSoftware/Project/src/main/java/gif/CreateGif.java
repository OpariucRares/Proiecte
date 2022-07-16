package gif;

import draw.DrawingPanel;

import javax.imageio.ImageIO;
import javax.imageio.stream.FileImageOutputStream;
import javax.imageio.stream.ImageOutputStream;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

public class CreateGif implements Runnable{
    @Override
    public void run() {
        try {
            ImageOutputStream output = new FileImageOutputStream(new File("src/main/java/gif/example.gif"));
            GifSequenceWriter writer = new GifSequenceWriter(output, 650, true);
            File folder = new File("src/main/java/gif/imagesGenerated");
            for(int i = 0; i < DrawingPanel.numberImages - 1; ++i) {
                BufferedImage next = ImageIO.read(new File("src/main/java/gif/imagesGenerated/images" + i + ".png"));
                writer.writeToSequence(next);
            }

            writer.close();
            output.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
