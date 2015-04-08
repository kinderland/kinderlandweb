package migracaokinderlandv2;

import java.io.IOException;
import java.util.Properties;

public class Base {

    public static Log log;
    public Properties propertiesFile;

    public Base() {
        Base.log = new Log();
        this.getPropertiesFromFile();
    }

    private void getPropertiesFromFile() {
        try {
            Properties prop = new Properties();
            prop.load(Log.class.getResourceAsStream("database.properties"));
            this.propertiesFile = prop;
        } catch (IOException e) {
            log.errorPrint(e);
        }
    }

    public String clearNameFile(String nameFile) {
        String name = nameFile.toLowerCase().replace("http://", "");
        name = name.toLowerCase().replace("/", ".");
        name = name.toLowerCase().replace("?", "_");
        name = name.toLowerCase().replace(" ", "_");
        name = name.replaceAll("[^\\p{ASCII}]", "");
        return name;
    }

}
